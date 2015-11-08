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

abstract class Response extends Collector implements FinalCollectorInterface
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

    /**
     * @return int
     */
    protected abstract function getStatusCode();

    /**
     * @return string
     */
    protected abstract function getStatusText();

    /**
     * @return string
     */
    protected abstract function getCharset();

    /**
     * @return int
     */
    protected abstract function getMaxAge();

    /**
     * @return int
     */
    protected abstract function getExpires();

    /**
     * @return \DateTime
     */
    protected abstract function getLastModified();

    /**
     * @return int
     */
    protected abstract function getTtl();
}