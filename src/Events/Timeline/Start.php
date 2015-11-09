<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 23:26
 */

namespace Ndrx\Profiler\Events\Timeline;

use Symfony\Component\EventDispatcher\Event;

class Start extends Event
{
    const EVENT_NAME = 'profiler.timeline_start';

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * Start constructor.
     * @param mixed $data
     * @param string $label
     * @param string $key
     * @param int $timestamp
     */
    public function __construct($key, $label, $data = null, $timestamp = null)
    {
        $this->data = $data;
        $this->label = $label;
        $this->key = $key;
        $this->timestamp = $timestamp === null ? microtime(true) : $timestamp;
    }


    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return float
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}
