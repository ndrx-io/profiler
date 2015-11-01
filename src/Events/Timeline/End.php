<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 23:26
 */

namespace Ndrx\Profiler\Events\Timeline;


use Symfony\Component\EventDispatcher\Event;

class End extends Event
{
    const EVENT_NAME = 'profiler.timeline_end';

    /**
     * @var string
     */
    protected $key;

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * End constructor.
     * @param string $key
     * @param int $timestamp
     */
    public function __construct($key, $timestamp = null)
    {
        $this->key = $key;
        $this->timestamp = is_null($timestamp) ? time() : $timestamp;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}