<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 20:43
 */

namespace Ndrx\Profiler\Collectors\Data;


use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Contracts\StartCollectorInterface;

class Context extends Collector implements StartCollectorInterface
{

    /**
     * Fetch data
     * @return mixed
     */
    public function resolve()
    {

        $this->data = [
            'environment' => php_sapi_name(),
            'process-id' => $this->process->getId(),
            'parent-process-id' => $this->process->getParentId(),
            'date' => date('Y-m-d'),
            'time' => date('H:m:s'),
            'timestamp' => time()
        ];
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
        return 'context';
    }
}