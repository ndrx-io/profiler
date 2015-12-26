<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 21/11/15
 * Time: 17:25
 */

namespace Ndrx\Profiler\Renderer\Html;


class Template
{

    /**
     * @var \Twig_Environment
     */
    protected $engine;

    protected static $instance;

    /**
     *
     */
    protected function __construct()
    {
        $loader = new \Twig_Loader_Filesystem([
            __DIR__ . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . 'views'
        ]);
        $this->engine = new \Twig_Environment($loader);
    }

    /**
     * @return Template
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return \Twig_Environment
     */
    public function getEngine()
    {
        return $this->engine;
    }
}