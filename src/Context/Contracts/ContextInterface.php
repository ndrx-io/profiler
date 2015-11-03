<?php

namespace Ndrx\Profiler\Context\Contracts;

use Ndrx\Profiler\Process;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 16:36
 */
interface ContextInterface
{
    /**
     * Load data from the context
     * session ID, process ID, ...
     * @return mixed
     */
    public function initiate();

    /**
     * Send session ID, process ID
     * @return mixed
     */
    public function sendDebugIds();

    /**
     * @return Process
     */
    public function getProcess();

    /**
     * @return Request
     */
    public function getRequest();

}
