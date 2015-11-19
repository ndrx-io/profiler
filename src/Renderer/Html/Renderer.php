<?php

namespace Ndrx\Profiler\Renderer;

/**
 * Interface Renderer
 * @package Ndrx\Profiler\Renderer
 */
abstract class Renderer implements RendererInterface
{
    /**
     * @var \Twig_Environment
     */
    public static $templateEngine;

    /**
     * Renderer constructor.
     */
    public function __construct()
    {

        if (is_null(self::$templateEngine)) {
            $loader = new \Twig_Loader_Filesystem($this->getTemplateFolder());
            self::$templateEngine = new \Twig_Environment($loader);
        } else {
            /** @var \Twig_Loader_Filesystem $loader */
            $loader = self::$templateEngine->getLoader();
            $paths = $loader->getPaths();
            if (array_search($this->getTemplateFolder(), $paths, true) === false) {
                $loader->addPath($this->getTemplateFolder());
            }
        }
    }


    /**
     * @return mixed
     */
    public function render()
    {
        return self::$templateEngine->render($this->getTemplate(), array_merge($this->getData(), [
            'debugger' => [
                'icon' => $this->getIcon(),
                'title' => $this->getTitle()
            ]
        ]));
    }
}