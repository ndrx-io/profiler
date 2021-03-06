<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 04/11/15
 * Time: 20:17
 */

namespace Ndrx\Profiler\Events;

use Symfony\Component\EventDispatcher\EventDispatcher;

trait DispatcherAwareTrait
{
    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * @return EventDispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * @param EventDispatcher $eventDispatcher
     * @return $this
     */
    public function setDispatcher(EventDispatcher $eventDispatcher)
    {
        $this->dispatcher = $eventDispatcher;

        return $this;
    }
}
