<?php

namespace Ndrx\Profiler;

use Ndrx\Profiler\Components\Logs\Simple;
use Ndrx\Profiler\Components\Timeline;
use Ndrx\Profiler\Collectors\Data\Request;
use Ndrx\Profiler\Context\Cli;
use Ndrx\Profiler\Context\Contracts\ContextInterface;
use Ndrx\Profiler\Context\Http;
use Ndrx\Profiler\Collectors\Contracts\CollectorInterface;
use Ndrx\Profiler\Collectors\Contracts\FinalCollectorInterface;
use Ndrx\Profiler\Collectors\Contracts\StartCollectorInterface;
use Ndrx\Profiler\Collectors\Contracts\StreamCollectorInterface;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\Events\DispatcherAwareInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

/**
 * Class Profiler
 *
 *
 * @method void start($key, $label, $data = null, $timetamp = null) Start a timeline event
 * @method void stop($key, $timetamp = null) Stop a timeline event
 * @method mixed monitor($label, \Closure $closure) Monitor a function
 *
 * @method null emergency($message, array $context = array())
 * @method null alert($message, array $context = array())
 * @method null critical($message, array $context = array())
 * @method null error($message, array $context = array())
 * @method null warning($message, array $context = array())
 * @method null notice($message, array $context = array())
 * @method null info($message, array $context = array())
 * @method null debug($message, array $context = array())
 * @method null log($level, $message, array $context = array())
 *
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
     * @var Timeline
     */
    protected $timeline;

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

    /**
     * @return string
     */
    public static function detectEnv()
    {
        if (self::$environment !== null) {
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

        $dispatcher = self::$instance->context->getProcess()->getDispatcher();
        self::$instance->timeline = new Timeline($dispatcher);
        self::$instance->logger = new Simple($dispatcher);
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
     * @return array
     */
    public function getCollectors()
    {
        return $this->collectors;
    }

    /**
     * @param LoggerInterface $logger
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        if ($logger instanceof DispatcherAwareInterface) {
            $logger->setDispatcher(self::$instance->context->getProcess()->getDispatcher());
        }

        $this->logger = $logger;

        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call($name, $arguments)
    {
        if ($this->logger !== null && method_exists($this->logger, $name)) {
            return call_user_func_array(array($this->logger, $name), $arguments);
        }

        if ($this->timeline !== null && method_exists($this->timeline, $name)) {
            return call_user_func_array(array($this->timeline, $name), $arguments);
        }

        throw new \BadMethodCallException('Method ' . $name . ' does not exist or is not callable');
    }
}
