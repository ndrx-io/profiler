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

class Included extends Collector implements FinalCollectorInterface
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
     * @return string
     */
    public function getPath()
    {
        return 'files';
    }

    public function validate()
    {
        if (!is_array($this->data)) {
            throw new \LogicException('Duration must be an array ' . json_encode($this->data) . ' given');
        }
    }

    /**
     * Fetch data
     * @return void
     */
    public function resolve()
    {
        $this->data = get_included_files();
    }
}
