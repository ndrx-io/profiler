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
class Memory implements DataSourceInterface
{
    const SUMMARY_KEY = 'summary';

    protected $memory = [];

    /**
     * @param int $offset
     * @param int $limit
     * @return mixed
     */
    public function all($offset = 0, $limit = 15)
    {
        return array_slice($this->memory, $offset, $limit);
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return count($this->memory);
    }

    /**
     * @param $processId
     * @return mixed
     */
    public function getProcess($processId)
    {
        $patchs = $this->memory[$processId];
        unset($patchs[self::SUMMARY_KEY]);
        foreach($patchs as $patch) {
            yield json_encode($patch);
        }
    }

    /**
     * @return mixed
     */
    public function clear()
    {
        $this->memory = [];
    }

    /**
     * @param $processId
     * @return mixed
     */
    public function deleteProcess($processId)
    {
        if (array_key_exists($processId, $this->memory)) {
            unset($this->memory[$processId]);
        }
    }

    /**
     * @param Process $process
     * @param array $item
     * @return mixed
     */
    public function save(Process $process, array $item)
    {
        if (!array_key_exists($process->getId(), $this->memory)) {
            $this->memory[$process->getId()] = [];
        }

        $this->memory[$process->getId()][] = $item;
    }

    /**
     * @param Process $process
     * @param array $item
     * @return mixed
     */
    public function saveSummary(Process $process, array $item)
    {
        if (!array_key_exists($process->getId(), $this->memory)) {
            $this->memory[$process->getId()] = [];
        }

        $this->memory[$process->getId()][self::SUMMARY_KEY] = $item;
    }
}
