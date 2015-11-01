<?php

namespace Ndrx\Context;

use Ndrx\Profiler\Process;
use Ndrx\Profiler\Session;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 16:38
 */
class Http extends Context
{
    const HEADER_SESSION = 'PROFILE-SESSION-ID';
    const HEADER_PROCESS = 'PROFILE-PROCESS-ID';

    public function initiate()
    {
        parent::initiate();

        $sessionId = $this->request->headers->get(self::HEADER_SESSION, null);
        $processId = $this->request->headers->get(self::HEADER_PROCESS, null);

        $session = null;
        if (is_null($sessionId)) {
            $session = Session::build();
        } else {
            $session = new Session($sessionId);
        }

        $this->process = Process::build($session, $processId);

        $this->sendDebugIds();
    }

    public function sendDebugIds()
    {
        header(self::HEADER_SESSION . ": " . $this->process->getSession()->getId());
        header(self::HEADER_PROCESS . ": " . $this->process->getId());
    }
}