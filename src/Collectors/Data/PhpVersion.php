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

class PhpVersion extends Collector implements StartCollectorInterface
{

    /**
     * Fetch data
     * @return mixed
     */
    public function resolve()
    {

        $this->data = phpversion();
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
        return 'php-version';
    }
}