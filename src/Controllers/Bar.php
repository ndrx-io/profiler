<?php

namespace Ndrx\Profiler\Controllers;

use Ndrx\Profiler\ProfilerInterface;
use Ndrx\Profiler\Renderer\Html\Bar as BarRenderer;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 21/11/15
 * Time: 17:16
 */
class Bar
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


    /**
     * @param $id
     * @return string
     */
    public function show($id)
    {
        $profile = $this->objectToArray($this->profiler->getProfile($id));
        $renderer = new BarRenderer($profile, $this->profiler);

        return $renderer->content();
    }

    /**
     * @param $obj
     * @return array
     */
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
