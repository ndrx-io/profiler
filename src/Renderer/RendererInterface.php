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
    public function content();

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
     * @param array $data
     * @return self
     */
    public function setData(array $data);

    /**
     * @return string
     */
    public function getIcon();

    /**
     * @return string
     */
    public function getTitle();
}