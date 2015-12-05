<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 22/11/15
 * Time: 19:01
 */

namespace Ndrx\Profiler\Renderer\Html\Data;


use Ndrx\Profiler\Renderer\Html\BarInterface;

class Event extends Collector implements BarInterface
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Event';
    }

    /**
     * @return string
     */
    public function getBadge()
    {
        if (empty($this->profile['value'])) {
            return '-';
        }

        return sprintf('%s (%s)', $this->getTitle(), count($this->profile['value']));
    }

    /**
     * @return string
     */
    public function getBarContent()
    {
        return false;
    }
}