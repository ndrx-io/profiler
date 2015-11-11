<?php
/**
 * User: LAHAXE Arnaud
 * Date: 05/11/2015
 * Time: 12:40
 * FileName : User.php
 * Project : profiler
 */

namespace Ndrx\Profiler\Collectors\Data;


use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Contracts\StartCollectorInterface;

abstract class Route extends Collector implements StartCollectorInterface
{
    /**
     * The path in the final json
     *
     * @example
     *              path /aa/bb
     *              will be transformed to
     *              {
     *              aa : {
     *              bb: <VALUE OF RESOLVE>
     *              }
     *              }
     * @return string
     */
    public function getPath()
    {
        return 'routes';
    }
}
