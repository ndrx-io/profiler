<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/11/15
 * Time: 20:52
 */

namespace Ndrx\Profiler\Collectors\Data;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Contracts\FinalCollectorInterface;
use Ndrx\Profiler\Renderer\BarRenderableInterface;
use Ndrx\Profiler\Renderer\RendererInterface;

abstract class Response extends Collector implements FinalCollectorInterface, BarRenderableInterface
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
        return 'response';
    }

    /**
     * Fetch data
     * @return void
     */
    public function resolve()
    {
        $this->data = [
            'status' => [
                'code' => $this->getStatusCode(),
                'text' => $this->getStatusText(),
            ],
            'charset' => $this->getCharset(),
            'maxAge' => $this->getMaxAge(),
            'expires' => $this->getExpires(),
            'lastModified' => $this->getLastModified(),
            'ttl' => $this->getTtl()
        ];
    }

    public function getDataFields()
    {
        return [
            'status', 'charset', 'maxAge', 'expires', 'lastModified', 'ttl'
        ];
    }

    /**
     * @return RendererInterface
     *
     * @throws \RuntimeException
     */
    public function getRenderer()
    {
        return new \Ndrx\Profiler\Renderer\Html\Data\Response();
    }

    /**
     * @return int
     */
    abstract public function getStatusCode();

    /**
     * @return string
     */
    abstract protected function getStatusText();

    /**
     * @return string
     */
    abstract protected function getCharset();

    /**
     * @return int
     */
    abstract protected function getMaxAge();

    /**
     * @return int
     */
    abstract protected function getExpires();

    /**
     * @return \DateTime
     */
    abstract protected function getLastModified();

    /**
     * @return int
     */
    abstract protected function getTtl();
}
