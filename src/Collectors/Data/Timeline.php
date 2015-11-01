<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 23:17
 */

namespace Ndrx\Profiler\Collectors\Data;


use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Contracts\StreamCollectorInterface;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\Events\Timeline\End;
use Ndrx\Profiler\Events\Timeline\Start;
use Ndrx\Profiler\JsonPatch;
use Ndrx\Profiler\Process;

class Timeline extends Collector implements StreamCollectorInterface
{
    /**
     * Timeline constructor.
     */
    public function __construct(Process $process, DataSourceInterface $dataSource, JsonPatch $jsonPatch = null)
    {
        parent::__construct($process, $dataSource, $jsonPatch);

        // create timeline domain
        $patch = $this->jsonPatch->generate($this->getPath(), JsonPatch::ACTION_ADD, [], false);
        $this->dataSource->save($this->process, [$patch]);

        $this->process->getDispatcher()->addListener(Start::EVENT_NAME, function (Start $event) {
            $this->data = [
                'key' => md5($event->getKey()),
                'start' => $event->getTimestamp(),
                'label' => $event->getKey(),
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
     * Fetch data
     * @return mixed
     */
    public function resolve()
    {

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