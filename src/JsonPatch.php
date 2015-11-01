<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 12:10
 */

namespace Ndrx\Profiler;

use Rs\Json\Patch;
use Rs\Json\Patch\FailedTestException;
use Rs\Json\Patch\InvalidOperationException;
use Rs\Json\Patch\InvalidPatchDocumentJsonException;
use Rs\Json\Patch\InvalidTargetDocumentJsonException;

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
     * @param array|string|boolean $value
     * @param $append
     * @return array
     */
    public function generate($path, $action, $value = false, $append = false)
    {
        return [
            'op' => $action,
            'path' => '/' . $path . ($append ? '/-' : ''),
            'value' => $value
        ];
    }

    /**
     * @param $path
     * @param $items
     * @param bool|false $append
     * @return array
     */
    public function generateArrayAdd($path, $items, $append = false)
    {
        $patches = [];
        $rootParentCreated = false;
        foreach ($items as $key => $element) {
            if(!$rootParentCreated) {
                $patches[] = $this->generate($path, JsonPatch::ACTION_ADD, [], false);
                $rootParentCreated = true;
            }

            $elementPath = $path;
            if (!$append && is_string($key)) {
                $elementPath .= '/' . $key;
            }

            $patches[] = $this->generate($elementPath, JsonPatch::ACTION_ADD, $element, $append);
        }

        return $patches;
    }


    /**
     * @param $patchs
     * @return mixed
     */
    public function compile($patchs)
    {
        $targetDocument = '{}';

        foreach ($patchs as $patch) {
            try {

                $patch = new Patch($targetDocument, $patch);
                $targetDocument = $patch->apply();
            } catch (InvalidPatchDocumentJsonException $e) {
                echo $e->getMessage();
            } catch (InvalidTargetDocumentJsonException $e) {
                echo $e->getMessage();
            } catch (InvalidOperationException $e) {
                echo $e->getMessage();
            } catch (FailedTestException $e) {
                echo $e->getMessage();
            }
        }

        return json_decode($targetDocument);
    }
}