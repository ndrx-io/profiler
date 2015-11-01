<?php

namespace Ndrx\Profiler;


use Ndrx\Context\Cli;
use Ndrx\Context\Contracts\ContextInterface;
use Ndrx\Context\Http;
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
    public function __construct()
    {
        $this->collectors = [
            'initial' => [],
            'final' => [],
            'stream' => []
        ];
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

                self::$instance->context = new Http();
                break;

            default:
                self::$instance->context = new Cli();
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
}
