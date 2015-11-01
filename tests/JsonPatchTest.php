<?php

namespace Ndrx\Skeleton\Test;

use Ndrx\Profiler\JsonPatch;

class JsonPatchTest extends \PHPUnit_Framework_TestCase
{

    public function testAdd()
    {
        $jsonPatch = new JsonPatch();
        $result = $jsonPatch->generate('aa', JsonPatch::ACTION_ADD, 'bar', false);
        $this->assertEquals('aa', $result['path']);
        $this->assertEquals('bar', $result['value']);
        $this->assertEquals(JsonPatch::ACTION_ADD, $result['op']);
    }

    public function testAddAppend()
    {
        $jsonPatch = new JsonPatch();
        $result = $jsonPatch->generate('aa', JsonPatch::ACTION_ADD, 'bar', true);
        $this->assertEquals('aa/-', $result['path']);
        $this->assertEquals('bar', $result['value']);
        $this->assertEquals(JsonPatch::ACTION_ADD, $result['op']);
    }

    public function testMove()
    {
        $jsonPatch = new JsonPatch();
        $result = $jsonPatch->generate('aa', JsonPatch::ACTION_MOVE, 'bar');
        $this->assertEquals('aa', $result['path']);
        $this->assertEquals('bar', $result['value']);
        $this->assertEquals(JsonPatch::ACTION_MOVE, $result['op']);
    }

    public function testDelete()
    {
        $jsonPatch = new JsonPatch();
        $result = $jsonPatch->generate('aa', JsonPatch::ACTION_REMOVE);
        $this->assertEquals('aa', $result['path']);
        $this->assertEquals(JsonPatch::ACTION_REMOVE, $result['op']);
    }

}