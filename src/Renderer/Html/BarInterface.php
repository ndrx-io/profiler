<?php

namespace Ndrx\Profiler\Renderer\Html;

use Ndrx\Profiler\Renderer\RendererInterface;

/**
 * Interface Bar
 * @package Ndrx\Profiler\Renderer
 */
interface BarInterface extends RendererInterface
{
    /**
     * @return string
     */
    public function getBadge();

    /**
     * @return string
     */
    public function getBarContent();
}
