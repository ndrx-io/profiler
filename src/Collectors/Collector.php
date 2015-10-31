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

abstract class Collector implements CollectorInterface
{

    protected $data = [];

    /** @var  DataSourceInterface */
    protected $dataSource;

    /**
     * Collector constructor.
     * @param DataSourceInterface $dataSource
     */
    public function __construct(DataSourceInterface $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * Convert data into jsonpatch query and save it in the data source
     * @return mixed
     */
    public function persist()
    {
        $path = $this->getPath();
        if ($this instanceof StreamCollectorInterface) {
            $path .= '/-';
        }

        $this->dataSource->save(
            [
                'op' => 'add',
                'path' => $path,
                'value' => $this->data
            ]
        );

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