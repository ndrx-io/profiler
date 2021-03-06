<?php

namespace Ndrx\Profiler\Context;

use Ndrx\Profiler\Process;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 16:38
 */
class Http extends Context
{
    const HEADER_PROCESS = 'Process-Id';

    public function initiate()
    {
        parent::initiate();

        $processId = $this->request->headers->get(self::HEADER_PROCESS, null);

        $this->process = Process::build($processId);
        $this->process->setContext($this);
    }

    public function sendDebugIds()
    {
        if (!headers_sent()) {
            header(self::HEADER_PROCESS . ': ' . $this->process->getId());
        }
    }
}
