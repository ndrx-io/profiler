<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 22/11/15
 * Time: 19:01
 */

namespace Ndrx\Profiler\Renderer\Html\Data;


use Ndrx\Profiler\Renderer\Html\BarInterface;

class Request extends Collector implements BarInterface
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Request';
    }

    /**
     * @return string
     */
    public function getBadge()
    {
        if (empty($this->profile['value'])) {
            return '-';
        }

        return strtoupper($this->profile['value']['method']) . ' ' . $this->profile['value']['uri'];
    }

    /**
     * @return string
     */
    public function getBarContent()
    {
        return false;
    }
}