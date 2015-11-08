<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 23:17
 */

namespace Ndrx\Profiler\Collectors\Data;

use Ndrx\Profiler\Collectors\StreamCollector;
use Ndrx\Profiler\Events\Timeline\End;
use Ndrx\Profiler\Events\Timeline\Start;
use Ndrx\Profiler\JsonPatch;

class Timeline extends StreamCollector
{
    /**
     * @author LAHAXE Arnaud
     *
     *
     */
    protected function registerListeners()
    {
        $this->process->getDispatcher()->addListener(Start::EVENT_NAME, function (Start $event) {
            $this->data = [
                'key' => md5($event->getKey()),
                'start' => $event->getTimestamp(),
                'label' => $event->getLabel(),
                'data' => $event->getData()
            ];
            $this->stream();
        });

        $this->process->getDispatcher()->addListener(End::EVENT_NAME, function (End $event) {
            $this->data = [
                'key' => md5($event->getKey()),
                'end' => $event->getTimestamp(),
            ];
            $this->stream();
        });
    }

    /**
     * The path in the final json
     * @example
     *  path /aa/bb
     *  will be transformed to
     *  {
     *     aa : {
     *              bb: <VALUE OF RESOLVE>
     *       }
     *  }
     * @return mixed
     */
    public function getPath()
    {
        return 'timeline';
    }

    /**
     * Write data in the datasource and clean current buffer
     * @return mixed
     */
    public function stream()
    {
        $key = $this->data['key'];
        unset($this->data['key']);
        $path = $this->getPath() . '/' . $key;
        if (!array_key_exists('end', $this->data)) {
            $patch = $this->jsonPatch->generate($path, JsonPatch::ACTION_ADD, $this->data, false);
        } else {
            $patch = $this->jsonPatch->generate($path . '/end', JsonPatch::ACTION_ADD, $this->data['end'], false);
        }

        $this->dataSource->save($this->process, [$patch]);
        $this->data = [];
    }
}
