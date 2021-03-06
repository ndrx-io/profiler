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

abstract class User extends Collector implements StartCollectorInterface, BarRenderableInterface
{
    protected $user;

    /**
     * Fetch data
     *
     * @return mixed
     */
    public function resolve()
    {
        $this->data = [
            'id'       => $this->getId(),
            'identifier' => $this->getIdentifier(),
            'detail'   => $this->getDetails()
        ];
    }

    public function getDataFields()
    {
        return [
            'id', 'identifier', 'detail'
        ];
    }

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
        return 'user';
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     *
     * @return self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return RendererInterface
     *
     * @throws \RuntimeException
     */
    public function getRenderer()
    {
        return new \Ndrx\Profiler\Renderer\Html\Data\User();
    }

    /**
     * Return the user user identifier email/username or whatever
     *
     * @return string
     */
    abstract public function getIdentifier();

    /**
     * Return the user id or uuid
     *
     * @return string|int
     */
    abstract public function getId();

    /**
     * User details for examples roles, timestamps...
     *
     * @return array
     */
    abstract public function getDetails();
}
