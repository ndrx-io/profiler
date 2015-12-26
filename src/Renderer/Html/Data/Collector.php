<?php

namespace Ndrx\Profiler\Renderer\Html\Data;

use Ndrx\Profiler\Renderer\Html\Renderer;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 21/11/15
 * Time: 18:35
 */
abstract class Collector extends Renderer
{

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        $reflectionClassName = new \ReflectionClass(get_class($this));
        $pattern = '/([a-z])([A-Z])/';
        $name = strtolower(preg_replace_callback($pattern, function ($a) {
            return $a[1] . '-' . strtolower($a[2]);
        }, $reflectionClassName->getShortName()));

        return 'tab' . DIRECTORY_SEPARATOR . $name . '.html.twig';
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'info';
    }
}
