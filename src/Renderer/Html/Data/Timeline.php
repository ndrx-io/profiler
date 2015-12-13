<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 22/11/15
 * Time: 19:01
 */

namespace Ndrx\Profiler\Renderer\Html\Data;


use Ndrx\Profiler\Renderer\Html\PageInterface;

class Timeline extends Collector implements PageInterface
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Timeline';
    }


    public function getData()
    {
        $data = $this->profile;
        $min = false;
        $max = false;

        foreach ($data['value'] as $key => $item) {
            if (is_bool($min) || $item['start'] < $min) {
                $min = $item['start'];
            }

            if (array_key_exists('end', $item)) {
                if (is_bool($max) || $item['end'] > $max) {
                    $max = $item['end'];
                }
            }
        }

        if ($min === 0) {
            $min = 1;
        }


        if ($max === 0) {
            $max = 1;
        }


        foreach ($data['value'] as $key => $item) {
            if (!array_key_exists('end', $item)) {
                $item['end'] = $max;
            }
            $data['value'][$key]['offset'] = floor((($item['start'] - $min) / $min) * 100);
            $data['value'][$key]['length'] = floor((($item['end'] - $item['start']) / ($max - $min)) * 100);
        }

        return $data;
    }

    public function getIcon()
    {
        return 'fa-play';
    }
}