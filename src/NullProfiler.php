<?php

namespace Ndrx\Profiler;

use Ndrx\Profiler\Context\Null;
use Psr\Log\LoggerInterface;
use Ndrx\Profiler\Collectors\Contracts\CollectorInterface;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\Components\Timeline;

/**
 * Class NullProfiler
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
        return new Memory();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProfile($id)
    {
        return [];
    }

    /**
     * @return \Ndrx\Profiler\Context\Contracts\ContextInterface
     */
    public function getContext()
    {

        return new Null();
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
    }
}
