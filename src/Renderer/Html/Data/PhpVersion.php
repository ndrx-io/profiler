<?php

namespace Ndrx\Profiler\Renderer\Html\Data;

use Ndrx\Profiler\Renderer\Html\BarInterface;
use Ndrx\Profiler\Renderer\Html\Renderer;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 21/11/15
 * Time: 18:35
 */
class PhpVersion extends Renderer implements BarInterface
{

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return 'bar' . DIRECTORY_SEPARATOR . 'php-version.html.twig';
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

    /**
     * @return string
     */
    public function getBadge()
    {
        return 'PHP';
    }

    /**
     * @return string
     */
    public function getBarContent()
    {
        if (array_key_exists('value', $this->profile)) {
            return $this->profile['value'];
        }

        return '-';
    }
}
