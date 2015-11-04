<?php

namespace Ndrx\Profiler;

use Ndrx\Profiler\Collectors\Data\Request;
use Ndrx\Profiler\Context\Cli;
use Ndrx\Profiler\Context\Contracts\ContextInterface;
use Ndrx\Profiler\Context\Http;
use Ndrx\Profiler\Collectors\Contracts\CollectorInterface;
use Ndrx\Profiler\Collectors\Contracts\FinalCollectorInterface;
use Ndrx\Profiler\Collectors\Contracts\StartCollectorInterface;
use Ndrx\Profiler\Collectors\Contracts\StreamCollectorInterface;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\Events\Timeline\End;
use Ndrx\Profiler\Events\Timeline\Start;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

/**
 * Class Profiler
 * @package Ndrx\Profiler
 */
class Profiler implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var ContextInterface
     */
    protected $context;

    /**
     * @var DataSourceInterface
     */
    protected $datasource;

    /**
     * @var Profiler
     */
    protected static $instance;

    /**
     * @var array
     */
    protected $collectors;

    /**
     * @var string
     */
    public static $environment;

    /**
     *
     */
    protected function __construct()
    {
        $this->collectors = [
            'initial' => [],
            'final' => [],
            'stream' => []
        ];
    }

    public function __destruct()
    {
        $this->terminate();
    }

    public static function detectEnv()
    {
        if(self::$environment !== null) {
            return self::$environment;
        }

        return php_sapi_name();
    }

    /**
     * @return Profiler
     */
    public static function getInstance()
    {
        if (!is_null(self::$instance)) {
            return self::$instance;
        }

        self::$instance = new self();
        // set the good context
        switch (self::detectEnv()) {
            case 'cli':

                self::$instance->context = new Cli();
                break;

            default:
                self::$instance->context = new Http();
        }

        self::$instance->context->initiate();

        return self::$instance;
    }

    /**
     * @author LAHAXE Arnaud
     */
    public static function destroy()
    {
        self::$instance = null;
    }

    /**
     * Add a data collector to the profiler
     * @param CollectorInterface $collector
     * @throws \RuntimeException
     */
    public function registerCollector(CollectorInterface $collector)
    {
        if ($collector instanceof StartCollectorInterface) {
            $this->collectors['initial'][$collector->getPath()] = $collector;
        } elseif ($collector instanceof FinalCollectorInterface) {
            $this->collectors['final'][$collector->getPath()] = $collector;
        } elseif ($collector instanceof StreamCollectorInterface) {
            $this->collectors['stream'][$collector->getPath()] = $collector;
        } else {
            throw new \RuntimeException('Collector must be implementation of StartCollectorInterface, '
                . 'FinalCollectorInterface or StreamCollectorInterface Path=' . $collector->getPath());
        }
    }

    /**
     * Register multiple collector to the profiler
     * @param array $collectors
     * @throws \RuntimeException
     */
    public function registerCollectors(array $collectors)
    {
        foreach ($collectors as $collector) {
            $this->registerCollector($collector);
        }
    }

    /**
     * Build and register collector class
     * @param $className
     * @throws \RuntimeException
     */
    public function registerCollectorClass($className)
    {
        /** @var CollectorInterface $collector */
        $collector = new $className($this->context->getProcess(), $this->datasource);
        $this->registerCollector($collector);
    }

    /**
     * Build and register collector classes
     * @param array $collectors
     * @throws \RuntimeException
     */
    public function registerCollectorClasses(array $collectors)
    {
        foreach ($collectors as $collector) {
            $this->registerCollectorClass($collector);
        }
    }

    /**
     * Run start collector at the profiler creation
     */
    public function initiate()
    {
        $this->runGroup('initial');
    }

    /**
     * Run final collectors, just before the profiler was destroy
     */
    public function terminate()
    {
        $this->runGroup('final');
    }

    public function runGroup($name)
    {
        /** @var CollectorInterface $collector */
        foreach ($this->collectors[$name] as $collector) {
            $collector->resolve();
            if ($collector instanceof Request) {
                $data = $collector->getData();

                $this->datasource->saveSummary($this->context->getProcess(), [
                    'id' => $this->context->getProcess()->getId(),
                    'method' => $data['method'],
                    'uri' => $data['uri'],
                    'time' => time()
                ]);
            }
            $collector->persist();
        }
    }

    /**
     * @param DataSourceInterface $datasource
     */
    public function setDataSource($datasource)
    {
        $this->datasource = $datasource;
    }

    /**
     * @return DataSourceInterface
     */
    public function getDatasource()
    {
        return $this->datasource;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProfile($id)
    {
        return (new JsonPatch())->compile($this->datasource->getProcess($id));
    }

    /**
     * @return ContextInterface
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Start item for the timeline
     *
     * @param $key
     * @param $label
     * @param null $data
     * @param null $timetamp
     */
    public function start($key, $label, $data = null, $timetamp = null)
    {
        $event = new Start($key, $label, $data, $timetamp);
        $this->getContext()->getProcess()->getDispatcher()->dispatch(Start::EVENT_NAME, $event);
    }

    /**
     * End item for the timeline
     *
     * @param $key
     * @param null $timetamp
     */
    public function stop($key, $timetamp = null)
    {
        $event = new End($key, $timetamp);
        $this->getContext()->getProcess()->getDispatcher()->dispatch(End::EVENT_NAME, $event);
    }

    /**
     * @return array
     */
    public function getCollectors()
    {
        return $this->collectors;
    }
}
