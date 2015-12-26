<?php
/**
 * User: LAHAXE Arnaud
 * Date: 05/11/2015
 * Time: 12:40
 * FileName : User.php
 * Project : profiler
 */

namespace Ndrx\Profiler\Collectors\Data;

use Ndrx\Profiler\Collectors\Contracts\StreamCollectorInterface;
use Ndrx\Profiler\Collectors\StreamCollector;
use Ndrx\Profiler\Renderer\BarRenderableInterface;
use Ndrx\Profiler\Renderer\RendererInterface;

abstract class Database extends StreamCollector implements StreamCollectorInterface, BarRenderableInterface
{
    /**
     * The path in the final json
     * @example
     *  path /aa/bb
     *  will be transformed to
     *  {
     *     aa : {
     *              bb: <VALUE OF RESOLVE>
     *       }
     *  }
     * @return mixed
     */
    public function getPath()
    {
        return 'database';
    }

    /**
     * @return RendererInterface
     *
     * @throws \RuntimeException
     */
    public function getRenderer()
    {
        return new \Ndrx\Profiler\Renderer\Html\Data\Database();
    }
}
