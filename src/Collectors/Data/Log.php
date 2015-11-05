<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 23:17
 */

namespace Ndrx\Profiler\Collectors\Data;

use Ndrx\Profiler\Collectors\StreamCollector;
use \Ndrx\Profiler\Events\Log as LogEvent;
use Ndrx\Profiler\JsonPatch;

class Log extends StreamCollector
{
    /**
     * @author LAHAXE Arnaud
     *
     *
     */
    protected function registerListeners()
    {
        $this->process->getDispatcher()->addListener(LogEvent::EVENT_NAME, function (LogEvent $event) {
            $this->data = $event->toArray();
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
        return 'logs';
    }

    /**
     * Write data in the datasource and clean current buffer
     * @return mixed
     */
    public function stream()
    {
        $patch = $this->jsonPatch->generate($this->getPath(), JsonPatch::ACTION_ADD, $this->data, true);
        $this->dataSource->save($this->process, [$patch]);
        $this->data = [];
    }
}
