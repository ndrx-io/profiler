<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 31/10/15
 * Time: 18:15
 */

namespace Ndrx\Profiler;


use Ndrx\Profiler\Context\Contracts\ContextInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Process
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $parentId;


    /**
     * @var ContextInterface
     */
    protected $context;

    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * @param null $id
     * @param null $parentId
     */
    public function __construct($id = null, $parentId = null)
    {
        $this->id = $id;
        $this->parentId = $parentId;

        $this->dispatcher = new EventDispatcher();
    }

    /**
     * @param null $parentId
     * @return Process
     */
    public static function build($parentId = null)
    {
        return new self(sha1(microtime() . uniqid()), $parentId);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ContextInterface
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param ContextInterface $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return string
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @return EventDispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }
}