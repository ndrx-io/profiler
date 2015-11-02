<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 20:43
 */

namespace Ndrx\Profiler\Collectors\Data;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Contracts\FinalCollectorInterface;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\JsonPatch;
use Ndrx\Profiler\Process;

class CpuUsage extends Collector implements FinalCollectorInterface
{
    protected $initialCpuUsage;
    /**
     * EventsDataSource constructor.
     */
    public function __construct(Process $process, DataSourceInterface $dataSource, JsonPatch $jsonPatch = null)
    {
        $cpu = getrusage();
        $this->initialCpuUsage = $cpu["ru_utime.tv_sec"] * 1e6 + $cpu["ru_utime.tv_usec"];

        parent::__construct($process, $dataSource, $jsonPatch);
    }


    /**
     * Fetch data
     * @return mixed
     */
    public function resolve()
    {
        $cpu = getrusage();

        $this->data = ($cpu["ru_utime.tv_sec"] * 1e6 + $cpu["ru_utime.tv_usec"]) - $this->initialCpuUsage;
    }

    /**
     * The path in the final json
     * @example
     *  path /aa/bb
     *  will be transformed to
     *  {
     *     aa : {
     *              bb: <VALUE OF RESOLVE>
     *       }
     *  }
     * @return string
     */
    public function getPath()
    {
        return 'cpu';
    }
}
