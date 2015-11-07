<?php

namespace Ndrx\Profiler;

use Monolog\Handler\AbstractProcessingHandler;
use Ndrx\Profiler\Collectors\Contracts\CollectorInterface;
use Ndrx\Profiler\Components\Timeline;
use Ndrx\Profiler\Context\Contracts\ContextInterface;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * Interface ProfilerInterface
 * @package Ndrx\Profiler
 */
interface ProfilerInterface extends LoggerAwareInterface
{
    /**
     * @return string
     */
    public static function detectEnv();

    /**
     * Add a data collector to the profiler
     * @param CollectorInterface $collector
     * @throws \RuntimeException
     */
    public function registerCollector(CollectorInterface $collector);

    /**
     * Register multiple collector to the profiler
     * @param array $collectors
     * @throws \RuntimeException
     */
    public function registerCollectors(array $collectors);

    /**
     * Build and register collector class
     * @param $className
     * @throws \RuntimeException
     */
    public function registerCollectorClass($className);

    /**
     * Build and register collector classes
     * @param array $collectors
     * @throws \RuntimeException
     */
    public function registerCollectorClasses(array $collectors);

    /**
     * Run start collector at the profiler creation
     */
    public function initiate();

    /**
     * Run final collectors, just before the profiler was destroy
     */
    public function terminate();

    /**
     * @param $name
     * @return mixed
     */
    public function runGroup($name);

    /**
     * @param DataSourceInterface $datasource
     */
    public function setDataSource($datasource);

    /**
     * @return DataSourceInterface
     */
    public function getDatasource();

    /**
     * @param $id
     * @return mixed
     */
    public function getProfile($id);

    /**
     * @return ContextInterface
     */
    public function getContext();

    /**
     * @param Timeline $timeline
     */
    public function setTimeline($timeline);

    /**
     * @return LoggerInterface|AbstractProcessingHandler
     */
    public function getLogger();
}
