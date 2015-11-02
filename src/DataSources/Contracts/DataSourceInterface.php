<?php

namespace Ndrx\Profiler\DataSources\Contracts;

use Ndrx\Profiler\Process;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 31/10/15
 * Time: 17:45
 */
interface DataSourceInterface
{
    public function getProcess($processId);

    public function clear();

    public function deleteProcess($processId);

    public function save(Process $process, array $item);
}
