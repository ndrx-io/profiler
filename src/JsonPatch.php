<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 12:10
 */

namespace Ndrx\Profiler;

/**
 * Class JsonPatch
 * @package Ndrx\Profiler
 */
class JsonPatch
{

    /**
     * Action are based on http://jsonpatch.com/ description
     *
     */
    const ACTION_ADD = 'add';
    const ACTION_REMOVE = 'remove';
    const ACTION_REPLACE = 'replace';
    const ACTION_COPY = 'copy';
    const ACTION_MOVE = 'move';
    const ACTION_TEST = 'test';

    /**
     * @param $path
     * @param $action
     * @param $value
     * @param $append
     * @return array
     */
    public function generate($path, $action, $value = false, $append = false)
    {
        return [
            'op' => $action,
            'path' => $path . ($append ? '/-' : ''),
            'value' => $value
        ];
    }
}