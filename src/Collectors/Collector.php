<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 31/10/15
 * Time: 17:40
 */

namespace Ndrx\Profiler\Collectors;


use Ndrx\Profiler\Collectors\Contracts\CollectorInterface;
use Ndrx\Profiler\Collectors\Contracts\StreamCollectorInterface;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\JsonPatch;
use Ndrx\Profiler\Process;

abstract class Collector implements CollectorInterface
{

    protected $data = [];

    /** @var  DataSourceInterface */
    protected $dataSource;

    /**
     * @var Process
     */
    protected $process;

    /**
     * @var JsonPatch
     */
    protected $jsonPatch;

    /**
     * @param Process $process
     * @param DataSourceInterface $dataSource
     * @param JsonPatch|null $jsonPatch
     */
    public function __construct(Process $process, DataSourceInterface $dataSource, JsonPatch $jsonPatch = null)
    {
        $this->dataSource = $dataSource;
        $this->process = $process;
        $this->jsonPatch = $jsonPatch;

        if(is_null($jsonPatch)) {
            $this->jsonPatch = new JsonPatch();
        }
    }

    /**
     * Convert data into jsonpatch query and save it in the data source
     * @return mixed
     */
    public function persist()
    {
        if(!is_array($this->data)) {
            $this->data = [$this->data];
        }

        foreach($this->data as $element) {
            $this->dataSource->save($this->jsonPatch->generate($this->getPath(), JsonPatch::ACTION_ADD, $element, $this instanceof StreamCollectorInterface));
        }

        $this->data = [];
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return DataSourceInterface
     */
    public function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * @param DataSourceInterface $dataSource
     */
    public function setDataSource($dataSource)
    {
        $this->dataSource = $dataSource;
    }
}