<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 31/10/15
 * Time: 17:40
 */

namespace Ndrx\Profiler\Collectors;

use Ndrx\Profiler\Collectors\Contracts\StreamCollectorInterface;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\JsonPatch;
use Ndrx\Profiler\Process;

/**
 * Class StreamCollector
 * @package Ndrx\Profiler\Collectors
 */
abstract class StreamCollector extends Collector implements StreamCollectorInterface
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

    abstract protected function registerListeners();
}
