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

class Bar extends Renderer
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


    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return 'bar.html.twig';
    }

    /**
     * @return mixed
     */
    public function getData()
    {

        $collectors = [];

        $dataCollectors = $this->profiler->getCollectors();
        $dataCollectors = call_user_func_array('array_merge', $dataCollectors);
        foreach ($dataCollectors as $collector) {
            if ($collector instanceof RenderableInterface) {
                $renderer = $collector->getRenderer();
                if ($renderer instanceof BarInterface) {
                    $data = [
                        'value' => null
                    ];

                    if (array_key_exists($collector->getPath(), $this->profile)) {
                        $data['value'] = $this->profile[$collector->getPath()];
                    }
                    $renderer->setData($data);

                    $data = [
                        'icon' => $renderer->getIcon(),
                        'badge' => $renderer->getBadge(),
                        'content' => $renderer->getBarContent(),
                    ];

                    $collectors[$collector->getName()] = $data;
                }
            }
        }

        return [
            'collectors' => $collectors
        ];
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