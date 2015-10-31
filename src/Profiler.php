<?php

namespace Ndrx\Profiler;


use Symfony\Component\HttpFoundation\Request;


/**
 * Class Profiler
 * @package Ndrx\Profiler
 */
class Profiler
{
    /**
     * @var Process
     */
    protected $process;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Profiler constructor.
     */
    public function __construct()
    {
        $this->request = Request::createFromGlobals();
        $this->loadContext();
        $this->sendProfilerHeaders();
    }


    /**
     * Build the process object
     * Load header and set good session and process parent
     */
    public function loadContext()
    {
        $sessionId = $this->request->headers->get('PROFILE-SESSION-ID', null);
        $processId = $this->request->headers->get('PROFILE-PROCESS-ID', null);

        $session = null;
        if(is_null($sessionId)) {
            $session = Session::build();
        } else {
            $session = new Session($sessionId);
        }

        $this->process = Process::build($session, $processId);
    }


    public function sendProfilerHeaders()
    {
        header("PROFILE-SESSION-ID: " . $this->process->getSession()->getId());
        header("PROFILE-PROCESS-ID: " . $this->process->getId());
    }
}
