<?php

namespace Ndrx\Profiler\Renderer\Html\Data;

use Ndrx\Profiler\Renderer\Html\Renderer;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 21/11/15
 * Time: 18:35
 */
class PhpVersion extends Renderer
{

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return 'data' . DIRECTORY_SEPARATOR . 'php-version.html.twig';
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'info';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Php version';
    }
}