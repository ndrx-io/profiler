<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 21/11/15
 * Time: 15:14
 */

namespace Ndrx\Profiler\Renderer\Html;

use Ndrx\Profiler\ProfilerInterface;

class BarLoader extends Renderer
{
    /**
     * @var ProfilerInterface
     */
    protected $profiler;

    /**
     * Process constructor.
     */
    public function __construct(array $profile, ProfilerInterface $profiler)
    {
        $this->profiler = $profiler;

        parent::__construct($profile);
    }

    public function getData()
    {
        return [
            'processId' => $this->profiler->getContext()->getProcess()->getId()
        ];
    }


    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return 'bar-loader.html.twig';
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'options';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Bar';
    }
}
