<?php

namespace Ndrx\Profiler;

use Ndrx\Profiler\Components\Logs\Simple;
use Ndrx\Profiler\Context\NullContext;
use Ndrx\Profiler\DataSources\NullDataSource;
use Psr\Log\LoggerInterface;
use Ndrx\Profiler\Collectors\Contracts\CollectorInterface;
use Ndrx\Profiler\Components\Timeline;

/**
 * Class NullProfiler
 *
 * @method void start($key, $label, $data = null, $timetamp = null) Start a timeline event
 * @method void stop($key, $timestamp = null) Stop a timeline event
 * @method mixed monitor($label, \Closure $closure) Monitor a function
 *
 * @method NullContext emergency($message, array $context = array())
 * @method NullContext alert($message, array $context = array())
 * @method NullContext critical($message, array $context = array())
 * @method NullContext error($message, array $context = array())
 * @method NullContext warning($message, array $context = array())
 * @method NullContext notice($message, array $context = array())
 * @method NullContext info($message, array $context = array())
 * @method NullContext debug($message, array $context = array())
 * @method NullContext log($level, $message, array $context = array())
 *
 * @package Ndrx\Profiler
 */
class NullProfiler implements ProfilerInterface
{
    /**
     * Sets a logger instance on the object
     *
     * @param \Psr\Log\LoggerInterface $logger
     * @return null
     */
    public function setLogger(LoggerInterface $logger)
    {
    }

    /**
     * @return string
     */
    public static function detectEnv()
    {
        return 'null';
    }

    /**
     * @author LAHAXE Arnaud
     */
    public static function destroy()
    {
    }

    /**
     * Add a data collector to the profiler
     * @param \Ndrx\Profiler\Collectors\Contracts\CollectorInterface $collector
     * @throws \RuntimeException
     */
    public function registerCollector(CollectorInterface $collector)
    {
    }

    /**
     * Register multiple collector to the profiler
     * @param array $collectors
     * @throws \RuntimeException
     */
    public function registerCollectors(array $collectors)
    {
    }

    /**
     * Build and register collector class
     * @param $className
     * @throws \RuntimeException
     */
    public function registerCollectorClass($className)
    {
    }

    /**
     * Build and register collector classes
     * @param array $collectors
     * @throws \RuntimeException
     */
    public function registerCollectorClasses(array $collectors)
    {
    }

    /**
     * Run start collector at the profiler creation
     */
    public function initiate()
    {
    }

    /**
     * Run final collectors, just before the profiler was destroy
     */
    public function terminate()
    {
    }

    /**
     * @param $name
     * @return mixed
     */
    public function runGroup($name)
    {
    }

    /**
     * @param \Ndrx\Profiler\DataSources\Contracts\DataSourceInterface $datasource
     */
    public function setDataSource($datasource)
    {
    }

    /**
     * @return \Ndrx\Profiler\DataSources\Contracts\DataSourceInterface
     */
    public function getDatasource()
    {
        return new NullDataSource();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProfile($id)
    {
        return new \stdClass();
    }

    /**
     * @return \Ndrx\Profiler\Context\Contracts\ContextInterface
     */
    public function getContext()
    {
        return new NullContext();
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call($name, $arguments)
    {
    }

    /**
     * @param Timeline $timeline
     */
    public function setTimeline($timeline)
    {
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return new Simple();
    }

    /**
     * @return array
     */
    public function getCollectors()
    {
        return [];
    }
}
