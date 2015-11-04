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
use \Ndrx\Profiler\Events\Log as LogEvent;
use Ndrx\Profiler\JsonPatch;
use Ndrx\Profiler\Process;

class Log extends Collector implements StreamCollectorInterface
{
    /**
     * @param Process $process
     * @param DataSourceInterface $dataSource
     * @param JsonPatch|null $jsonPatch
     */
    public function __construct(Process $process, DataSourceInterface $dataSource, JsonPatch $jsonPatch = null)
    {
        parent::__construct($process, $dataSource, $jsonPatch);

        // create logs domain
        $patch = $this->jsonPatch->generate($this->getPath(), JsonPatch::ACTION_ADD, [], false);
        $this->dataSource->save($this->process, [$patch]);
        $this->registerListeners();
    }

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

