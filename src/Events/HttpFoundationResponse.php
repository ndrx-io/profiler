<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 23:26
 */

namespace Ndrx\Profiler\Events;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;

class HttpFoundationResponse extends Event
{
    const EVENT_NAME = 'response.foundation';

    /**
     * @var Response
     */
    protected $response;


    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
