<?php

namespace Ndrx\Profiler\DataSources\Contracts;

use Ndrx\Profiler\Process;

/**
 * Interface DataSourceInterface
 * @package Ndrx\Profiler\DataSources\Contracts
 */
interface DataSourceInterface
{
    /**
     * @param int $offset
     * @param int $limit
     * @return mixed
     */
    public function all($offset = 0, $limit = 15);

    /**
     * @return mixed
     */
    public function count();

    /**
     * @param $processId
     * @return mixed
     */
    public function getProcess($processId);

    /**
     * @return mixed
     */
    public function clear();

    /**
     * @param $processId
     * @return mixed
     */
    public function deleteProcess($processId);

    /**
     * @param Process $process
     * @param array $item
     * @return mixed
     */
    public function save(Process $process, array $item);

    /**
     * @param Process $process
     * @param array $item
     * @return mixed
     */
    public function saveSummary(Process $process, array $item);
}
