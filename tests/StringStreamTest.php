<?php
namespace Test;

// \Spl
use Exception;

// \HttpStream
use Kambo\Http\Stream\StringStream;

/**
 * Unit test for the CallbackStream object.
 *
 * @package Test
 * @author  Bohuslav Simek <bohuslav@simek.si>
 * @license MIT
 */
class StringStreamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test creating stream
     * 
     * @return void
     */
    public function testCreate()
    {
        $stringStream = new StringStream('test');
        $this->assertEquals('test', $stringStream->getContents());
    }
}
