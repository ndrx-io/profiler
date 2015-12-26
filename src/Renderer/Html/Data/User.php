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

class User extends Collector implements BarInterface, PageInterface
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'User';
    }


    /**
     * @return string
     */
    public function getBadge()
    {
        if (empty($this->profile['value']['id'])) {
            return '-';
        }

        return $this->profile['value']['identifier'];
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
        return 'fa-user';
    }
}
