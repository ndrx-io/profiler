<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 22/11/15
 * Time: 19:01
 */

namespace Ndrx\Profiler\Renderer\Html\Data;


class Response extends Collector
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Response';
    }
}