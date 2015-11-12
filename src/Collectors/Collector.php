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
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class Collector implements CollectorInterface
{
    /**
     * @var mixed
     */
    protected $data;

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
     * @var Validator
     */
    protected $validator;

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

        if ($jsonPatch === null) {
            $this->jsonPatch = new JsonPatch();
        }

        $this->validator = new Validator($this->getDataFields(), $this->getDefaultValue());
    }

    /**
     * @return array
     */
    public function getDataFields()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getDefaultValue()
    {
        return [];
    }

    /**
     * Convert data into jsonpatch query and save it in the data source
     * @return mixed
     */
    public function persist()
    {
        $this->validate();

        if (!is_array($this->data)) {
            $this->data = [$this->data];
        }

        $append = $this instanceof StreamCollectorInterface;
        $patches = $this->jsonPatch->generateArrayAdd($this->getPath(), $this->data, $append);
        $this->dataSource->save($this->process, $patches);

        $this->data = [];
    }

    public function validate()
    {
        $this->validator->validate($this->data);
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
