<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 21/11/15
 * Time: 15:14
 */

namespace Ndrx\Profiler\Renderer\Html;

use Ndrx\Profiler\ProfilerInterface;
use Ndrx\Profiler\Renderer\RenderableInterface;

class ProcessList extends Renderer
{
    /**
     * @var array
     */
    protected $profiles;

    /**
     * @param array $profiles
     */
    public function __construct(array $profiles)
    {
        $this->profiles = $profiles;

        parent::__construct([]);
    }

    public function getData()
    {
        return [
            'profiles' => $this->profiles
        ];
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return 'process-list.html.twig';
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
        return 'Profiles list';
    }
}