<?php

namespace Ndrx\Profiler\Context;

use Ndrx\Profiler\Process;


/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 16:38
 */
class NullContext extends Context
{
    /**
     * NullContext constructor.
     */
    public function __construct()
    {
        $this->process = Process::build();
    }

    public function initiate()
    {
    }

    public function sendDebugIds()
    {
    }
}
