<?php

namespace Ndrx\Profiler;


use Ndrx\Profiler\Context\Cli;
use Ndrx\Profiler\Context\Contracts\ContextInterface;
use Ndrx\Profiler\Context\Http;
use Ndrx\Profiler\Collectors\Contracts\CollectorInterface;
use Ndrx\Profiler\Collectors\Contracts\FinalCollectorInterface;
use Ndrx\Profiler\Collectors\Contracts\StartCollectorInterface;
use Ndrx\Profiler\Collectors\Contracts\StreamCollectorInterface;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;


/**
 * Class Profiler
 * @package Ndrx\Profiler
 */
class Profiler
{

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
     * @return Profiler
     */
    public static function getInstance()
    {
        if (!is_null(self::$instance)) {
            return self::$instance;
        }

        self::$instance = new self();
        // set the good context
        switch (php_sapi_name()) {
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
}
