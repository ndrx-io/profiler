<?php

namespace Ndrx\Profiler\Collectors\Contracts;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 31/10/15
 * Time: 17:33
 */
interface CollectorInterface
{

    /**
     * Fetch data
     * @return mixed
     */
    public function resolve();

    /**
     * Convert data into jsonpatch query and save it in the datasource
     * @return mixed
     */
    public function persist();

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
    public function getPath();
}