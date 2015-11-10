<?php
/**
 * User: LAHAXE Arnaud
 * Date: 05/11/2015
 * Time: 12:40
 * FileName : User.php
 * Project : profiler
 */

namespace Ndrx\Profiler\Collectors\Data;

use Ndrx\Profiler\Collectors\Contracts\StreamCollectorInterface;
use Ndrx\Profiler\Collectors\StreamCollector;

abstract class Template extends StreamCollector implements StreamCollectorInterface
{
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
        return 'template';
    }
}
