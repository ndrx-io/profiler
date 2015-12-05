<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 22/11/15
 * Time: 19:01
 */

namespace Ndrx\Profiler\Renderer\Html\Data;


use Ndrx\Profiler\Renderer\Html\BarInterface;

class Log extends Collector implements BarInterface
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
        return $this->getTitle() . sprintf('(%s)', count($this->getData()));
    }

    /**
     * @return string
     */
    public function getBarContent()
    {
        return false;
    }
}