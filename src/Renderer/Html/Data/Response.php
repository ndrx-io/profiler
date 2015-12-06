<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 22/11/15
 * Time: 19:01
 */

namespace Ndrx\Profiler\Renderer\Html\Data;


use Ndrx\Profiler\Renderer\Html\BarInterface;
use Ndrx\Profiler\Renderer\Html\PageInterface;

class Response extends Collector implements BarInterface, PageInterface
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Response';
    }


    /**
     * @return string
     */
    public function getBadge()
    {
        if (empty($this->profile['value'])) {
            return '-';
        }

        return $this->profile['value']['status']['code'];
    }

    /**
     * @return string
     */
    public function getBarContent()
    {
        return false;
    }

    public function getIcon()
    {
        return 'fa-arrow-up';
    }
}