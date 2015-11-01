<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 31/10/15
 * Time: 18:15
 */

namespace Ndrx\Profiler;


use Ndrx\Context\Contracts\ContextInterface;

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
     * @var Session
     */
    protected $session;

    /**
     * @var ContextInterface
     */
    protected $context;


    /**
     * @param Session $session
     * @param null $id
     * @param null $parentId
     */
    public function __construct(Session $session, $id = null, $parentId = null)
    {
        $this->id = $id;
        $this->parentId = $parentId;
        $this->session = $session;
    }

    /**
     * @param Session $session
     * @param null $parentId
     * @return Process
     */
    public static function build(Session $session, $parentId = null)
    {
        return new self($session, sha1(microtime() . uniqid()), $parentId);
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param Session $session
     */
    public function setSession($session)
    {
        $this->session = $session;
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
}