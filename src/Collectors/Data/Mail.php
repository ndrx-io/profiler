<?php
/**
 * User: LAHAXE Arnaud
 * Date: 05/11/2015
 * Time: 12:40
 * FileName : User.php
 * Project : profiler
 */

namespace Collectors\Contracts;

use Ndrx\Profiler\Collectors\Contracts\StreamCollectorInterface;

abstract class Mail implements StreamCollectorInterface
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
        return 'mails';
    }
}
