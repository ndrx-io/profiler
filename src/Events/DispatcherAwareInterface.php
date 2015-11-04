<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 04/11/15
 * Time: 20:17
 */

namespace Ndrx\Profiler\Events;

use Symfony\Component\EventDispatcher\EventDispatcher;

interface DispatcherAwareInterface
{

    /**
     * @return EventDispatcher
     */
    public function getDispatcher();

    /**
     * @param EventDispatcher $eventDispatcher
     * @return $this
     */
    public function setDispatcher(EventDispatcher $eventDispatcher);
}