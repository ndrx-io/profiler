<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 22/11/15
 * Time: 19:01
 */

namespace Ndrx\Profiler\Renderer\Html\Data;


use Ndrx\Profiler\Renderer\Html\BarInterface;

class CpuUsage extends Collector implements BarInterface
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'CpuUsage';
    }

    /**
     * @return string
     */
    public function getBadge()
    {
        if (empty($this->profile['value'])) {
            return '-';
        }

        return round($this->profile['value'] / 1000, 3) . 'ms';
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
        return 'fa-heartbeat';
    }
}