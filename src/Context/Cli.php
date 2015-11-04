<?php

namespace Ndrx\Profiler\Context;

use Ndrx\Profiler\Process;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 16:38
 */
class Cli extends Context
{
    public function initiate()
    {
        parent::initiate();

        $this->process = Process::build();
        $this->process->setContext($this);
        $this->sendDebugIds();
    }

    public function sendDebugIds()
    {
    }
}
