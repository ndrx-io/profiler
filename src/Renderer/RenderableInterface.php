<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 21/11/15
 * Time: 13:47
 */

namespace Ndrx\Profiler\Renderer;

interface RenderableInterface
{
    /**
     * @return RendererInterface
     */
    public function getRenderer();

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getName();
}
