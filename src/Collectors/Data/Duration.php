<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 20:43
 */

namespace Ndrx\Profiler\Collectors\Data;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Contracts\FinalCollectorInterface;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\JsonPatch;
use Ndrx\Profiler\Process;
use Ndrx\Profiler\Renderer\BarRenderableInterface;

class Duration extends Collector implements FinalCollectorInterface, BarRenderableInterface
{
    protected $start;
    /**
     * EventsDataSource constructor.
     */
    public function __construct(Process $process, DataSourceInterface $dataSource, JsonPatch $jsonPatch = null)
    {
        $this->start = microtime(true);

        parent::__construct($process, $dataSource, $jsonPatch);
    }

    public function validate()
    {
        if (!is_numeric($this->data)) {
            throw new \LogicException('Duration must be a number ' . json_encode($this->data) . ' given');
        }
    }

    /**
     * Fetch data
     * @return mixed
     */
    public function resolve()
    {
        $end = microtime(true);

        $this->data = $end - $this->start;
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
     * @return string
     */
    public function getPath()
    {
        return 'duration';
    }
}
