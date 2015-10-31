<?php

namespace Ndrx\Skeleton\Test;

class ExampleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test of our dummy class
     */
    public function testTrueIsTrue()
    {
        $testTxt = uniqid();
        $skeleton = new \Ndrx\Skeleton\SkeletonClass();
		$this->assertEquals($testTxt, $skeleton->echoPhrase($testTxt));
    }
}