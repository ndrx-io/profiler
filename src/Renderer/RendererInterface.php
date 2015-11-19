<?php

namespace Ndrx\Profiler\Renderer;

/**
 * Interface Renderer
 * @package Ndrx\Profiler\Renderer
 */
interface RendererInterface
{
    /**
     * @return mixed
     */
    public function render();

    /**
     * @return mixed
     */
    public function getTemplate();

    /**
     * @return string
     */
    public function getTemplateFolder();

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return string
     */
    public function getIcon();

    /**
     * @return string
     */
    public function getTitle();
}