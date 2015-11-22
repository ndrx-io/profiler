<?php

namespace Ndrx\Profiler\Controllers;

use Ndrx\Profiler\ProfilerInterface;
use Ndrx\Profiler\Renderer\Html\Process;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 21/11/15
 * Time: 17:16
 */
class Web
{

    /**
     * @var ProfilerInterface
     */
    protected $profiler;

    /**
     * Web constructor.
     * @param ProfilerInterface $profiler
     */
    public function __construct(ProfilerInterface $profiler)
    {
        $this->profiler = $profiler;
    }


    public function index()
    {

    }

    public function show($id)
    {
        $profile = $this->objectToArray($this->profiler->getProfile($id));
        $renderer = new Process($profile, $this->profiler);

        return $renderer->content();
    }

    protected function objectToArray($obj)
    {
        if (is_object($obj)) {
            $obj = (array)$obj;
        }

        if (is_array($obj)) {
            $new = array();
            foreach ($obj as $key => $val) {
                $new[$key] = $this->objectToArray($val);
            }
        } else {
            $new = $obj;
        }

        return $new;
    }
}