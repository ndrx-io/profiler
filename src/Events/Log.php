<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 23:26
 */

namespace Ndrx\Profiler\Events;

use Symfony\Component\EventDispatcher\Event;

class Log extends Event
{

    const EVENT_NAME = 'profiler.log';

    protected $level;

    protected $message;

    protected $context;

    protected $stack;

    /**
     * Log constructor.
     * @param $level
     * @param $message
     * @param $context
     * @param $stack
     */
    public function __construct($level, $message, $context, $stack)
    {
        $this->level = $level;
        $this->message = $message;
        $this->context = $context;
        $this->stack = $stack;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return mixed
     */
    public function getStack()
    {
        return $this->stack;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}
