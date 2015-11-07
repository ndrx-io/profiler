<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 19:46
 */

namespace Ndrx\Profiler\DataSources;

use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\Process;

/**
 * Class Memory
 *
 * @package Ndrx\Profiler\DataSources
 */
class NullDataSource implements DataSourceInterface
{

    protected $memory = [];

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return mixed
     */
    public function all($offset = 0, $limit = 15)
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return 0;
    }

    /**
     * @param $processId
     *
     * @return \Generator
     */
    public function getProcess($processId)
    {
        return new \Generator();
    }

    /**
     * @return mixed
     */
    public function clear()
    {
        return true;
    }

    /**
     * @param $processId
     *
     * @return mixed
     */
    public function deleteProcess($processId)
    {
        return true;
    }

    /**
     * @param Process $process
     * @param array   $item
     *
     * @return mixed
     */
    public function save(Process $process, array $item)
    {
        return true;
    }

    /**
     * @param Process $process
     * @param array   $item
     *
     * @return mixed
     */
    public function saveSummary(Process $process, array $item)
    {
        return true;
    }
}
