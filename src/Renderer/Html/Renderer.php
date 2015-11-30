<?php

namespace Ndrx\Profiler\Renderer\Html;

use Ndrx\Profiler\Renderer\RendererInterface;

/**
 * Interface Renderer
 * @package Ndrx\Profiler\Renderer
 */
abstract class Renderer implements RendererInterface
{
    /**
     * @var array
     */
    protected $profile;

    /**
     * Renderer constructor.
     */
    public function __construct(array $profile = [])
    {
        $this->profile = $profile;

        /** @var \Twig_Loader_Filesystem $loader */
        $loader = Template::getInstance()->getEngine()->getLoader();
        $paths = $loader->getPaths();
        if (!in_array($this->getTemplateFolder(), $paths, true)) {
            $loader->addPath($this->getTemplateFolder());
        }

    }


    /**
     * @return string
     */
    public function content()
    {
        return Template::getInstance()->getEngine()->render($this->getTemplate(), array_merge($this->getData(), [
            'meta' => [
                'icon' => $this->getIcon(),
                'title' => $this->getTitle()
            ]
        ]));
    }

    public function getData()
    {
        return $this->profile;
    }

    public function setData(array $data)
    {
        $this->profile = $data;

        return $this;
    }

    public function getTemplateFolder()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..'
        . DIRECTORY_SEPARATOR . '..'
        . DIRECTORY_SEPARATOR . '..'
        . DIRECTORY_SEPARATOR . 'views';
    }
}