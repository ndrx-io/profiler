<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 31/10/15
 * Time: 18:18
 */

namespace Ndrx\Profiler;


class Session
{
    protected $id;

    /**
     * Session constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return Session
     */
    public static function build()
    {
        return new self(sha1(microtime() . uniqid()));
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}