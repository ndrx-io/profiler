<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 04/11/15
 * Time: 20:53
 */

namespace Ndrx\Profiler\Components;

use Ndrx\Profiler\Events\DispatcherAwareInterface;
use Ndrx\Profiler\Events\DispatcherAwareTrait;
use Ndrx\Profiler\Events\Timeline\End;
use Ndrx\Profiler\Events\Timeline\Start;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Timeline implements DispatcherAwareInterface
{
    use DispatcherAwareTrait;

    /**
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->dispatcher = $eventDispatcher;
    }


    /**
     * Start item for the timeline
     *
     * @param $key
     * @param $label
     * @param null $data
     * @param null $timetamp
     */
    public function start($key, $label, $data = null, $timetamp = null)
    {
        $event = new Start($key, $label, $data, $timetamp);
        $this->dispatcher->dispatch(Start::EVENT_NAME, $event);
    }

    /**
     * End item for the timeline
     *
     * @param $key
     * @param null $timetamp
     */
    public function stop($key, $timetamp = null)
    {
        $event = new End($key, $timetamp);
        $this->dispatcher->dispatch(End::EVENT_NAME, $event);
    }

    /**
     * @param $label
     * @param \Closure $closure
     * @raturn mixed
     */
    public function monitor($label, \Closure $closure)
    {
        $key = uniqid();
        $this->start($key, $label);
        $result = $closure();
        $this->start($key, $label);

        return $result;
    }
}
