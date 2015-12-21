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

class Log extends Collector implements BarInterface, PageInterface
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Log';
    }

    /**
     * @return string
     */
    public function getBadge()
    {
        return sprintf('%s (%s)', $this->getTitle(), count($this->getData()));
    }

    /**
     * @return string
     */
    public function getBarContent()
    {
        return json_encode($this->getData());
    }

    public function getIcon()
    {
        return 'fa-list-alt';
    }
}