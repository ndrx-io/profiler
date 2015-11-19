<?php

namespace Ndrx\Profiler\Renderer\Html;

use Ndrx\Profiler\Renderer\RendererInterface;

/**
 * Interface Bar
 * @package Ndrx\Profiler\Renderer
 */
interface Bar extends RendererInterface
{
    /**
     * @return string
     */
    public function renderInfoBox();
}