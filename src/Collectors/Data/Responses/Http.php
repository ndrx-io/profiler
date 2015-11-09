<?php

namespace Ndrx\Profiler\Collectors\Data\Responses;

use Ndrx\Profiler\Collectors\Data\Response;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\Events\HttpFoundationResponse;
use Ndrx\Profiler\JsonPatch;
use Ndrx\Profiler\Process;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/11/15
 * Time: 21:02
 */
class Http extends Response
{

    /**
     * @var  \Symfony\Component\HttpFoundation\Response
     */
    protected $response;

    /**
     * @param Process $process
     * @param DataSourceInterface $dataSource
     * @param JsonPatch|null $jsonPatch
     */
    public function __construct(Process $process, DataSourceInterface $dataSource, JsonPatch $jsonPatch = null)
    {
        parent::__construct($process, $dataSource, $jsonPatch);

        $this->process->getDispatcher()->addListener(HttpFoundationResponse::EVENT_NAME, function (HttpFoundationResponse $event) {
            $this->response = $event->getResponse();
        });
    }

    /**
     * @return int
     */
    protected function getStatusCode()
    {
        if ($this->response === null) {
            return null;
        }

        return $this->response->getStatusCode();
    }

    /**
     * @return string
     */
    protected function getStatusText()
    {
        if ($this->response === null) {
            return null;
        }

        return FoundationResponse::$statusTexts[$this->getStatusCode()];
    }

    /**
     * @return string
     */
    protected function getCharset()
    {
        if ($this->response === null) {
            return null;
        }

        return $this->response->getCharset();
    }

    /**
     * @return int
     */
    protected function getMaxAge()
    {
        if ($this->response === null) {
            return null;
        }

        return $this->response->getMaxAge();
    }

    /**
     * @return int
     */
    protected function getExpires()
    {
        if ($this->response === null) {
            return null;
        }

        return $this->response->getExpires();
    }

    /**
     * @return \DateTime
     */
    protected function getLastModified()
    {
        if ($this->response === null) {
            return null;
        }

        return $this->response->getLastModified();
    }

    /**
     * @return int
     */
    protected function getTtl()
    {
        if ($this->response === null) {
            return null;
        }

        return $this->response->getTtl();
    }
}
