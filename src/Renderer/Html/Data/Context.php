<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 22/11/15
 * Time: 19:01
 */

namespace Ndrx\Profiler\Renderer\Html\Data;


use Ndrx\Profiler\Renderer\Html\BarInterface;

class Context extends Collector implements BarInterface
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Context';
    }

    /**
     * @return string
     */
    public function getBadge()
    {
        if (empty($this->profile['value'])) {
            return '-';
        }

        return  $this->profile['value']['environment'];
    }

    /**
     * @return string
     */
    public function getBarContent()
    {
        return false;
    }
}