<?php
/**
 * User: LAHAXE Arnaud
 * Date: 05/11/2015
 * Time: 12:40
 * FileName : User.php
 * Project : profiler
 */

namespace Ndrx\Profiler\Collectors\Data;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Contracts\StartCollectorInterface;
use Ndrx\Profiler\Renderer\BarRenderableInterface;
use Ndrx\Profiler\Renderer\RendererInterface;

abstract class Route extends Collector implements StartCollectorInterface, BarRenderableInterface
{
    /**
     * The path in the final json
     *
     * @example
     *              path /aa/bb
     *              will be transformed to
     *              {
     *              aa : {
     *              bb: <VALUE OF RESOLVE>
     *              }
     *              }
     * @return string
     */
    public function getPath()
    {
        return 'route';
    }

    public function getDataFields()
    {
        return [
            'method', 'uri', 'name', 'action', 'middleware'
        ];
    }

    public function validate()
    {
        foreach ($this->data as $element) {
            $this->validator->validate($element);
        }
    }

    /**
     * @return RendererInterface
     *
     * @throws \RuntimeException
     */
    public function getRenderer()
    {
        return new \Ndrx\Profiler\Renderer\Html\Data\Route();
    }
}
