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

class Context extends Collector implements BarInterface, PageInterface
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

        return $this->profile['value']['environment'];
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
        return 'fa-compass';
    }
}
