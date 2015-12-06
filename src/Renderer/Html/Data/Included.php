<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 22/11/15
 * Time: 19:01
 */

namespace Ndrx\Profiler\Renderer\Html\Data;


use Ndrx\Profiler\Renderer\Html\PageInterface;

class Included extends Collector implements PageInterface
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Included';
    }

    public function getIcon()
    {
        return 'fa-file';
    }
}