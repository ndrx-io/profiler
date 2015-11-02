<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 16:42
 */

namespace Ndrx\Profiler\Context;

use Ndrx\Profiler\Context\Contracts\ContextInterface;
use Ndrx\Profiler\Process;
use Symfony\Component\HttpFoundation\Request;

abstract class Context implements ContextInterface
{
    /**
     * @var Process
     */
    protected $process;

    /**
     * @var Request
     */
    protected $request;

    public function initiate()
    {
        $this->request = Request::createFromGlobals();
    }

    /**
     * @return Process
     */
    public function getProcess()
    {
        return $this->process;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
