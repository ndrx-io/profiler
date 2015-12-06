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

class Config extends Collector implements PageInterface, BarInterface
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Config';
    }

    /**
     * @return string
     */
    public function getBadge()
    {
        // TODO: Implement getBadge() method.
    }

    /**
     * @return string
     */
    public function getBarContent()
    {
        return false;
    }
}