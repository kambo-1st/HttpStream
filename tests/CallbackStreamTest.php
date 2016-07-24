<?php
namespace Test;

// \Spl
use Exception;

// \HttpStream
use Kambo\Http\Stream\CallbackStream;

/**
 * Unit test for the CallbackStream object.
 *
 * @package Test
 * @author  Bohuslav Simek <bohuslav@simek.si>
 * @license MIT
 */
class CallbackStreamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test creating stream
     * 
     * @return void
     */
    public function testCreate()
    {
        $callbackStream = $this->getObjectForTest();
        $this->assertEquals('test', $callbackStream->getContents());
    }

    /**
     * Test closing stream - content of stream should be empty string.
     * 
     * @return void
     */
    public function testClose()
    {
        $callbackStream = $this->getObjectForTest();
        $callbackStream->close();

        $this->assertEquals('', $callbackStream->getContents());
    }

    /**
     * Test detach stream
     * 
     * @return void
     */
    public function testDetach()
    {
        $callback = function () {
            return 'test';
        };
        $callbackStream = new CallbackStream($callback);
        $oldCallback    = $callbackStream->detach();

        $this->assertEquals($callback, $oldCallback);
    }

    /**
     * Test get size - value must be null as there is no way how determine size
     * of the callback stream.
     * 
     * @return void
     */
    public function testGetSize()
    {
        $callbackStream = $this->getObjectForTest();
        $this->assertNull($callbackStream->getSize());
    }

    /**
     * Test tell - callback stream does not support tell function.
     * 
     * @expectedException \RuntimeException
     *
     * @return void
     */
    public function testTell()
    {
        $callbackStream = $this->getObjectForTest();
        $callbackStream->tell();
    }

    /**
     * Test eof - callback stream is never on eof.
     * 
     * @return void
     */
    public function testEof()
    {
        $callbackStream = $this->getObjectForTest();
        $this->assertFalse($callbackStream->eof());
    }

    /**
     * Test is seekable - callback stream is not seekable.
     * 
     * @return void
     */
    public function testIsSeekable()
    {
        $callbackStream = $this->getObjectForTest();
        $this->assertFalse($callbackStream->isSeekable());
    }

    /**
     * Test seek - there is no way how to perform seek in the callback stream.
     * 
     * @expectedException \RuntimeException
     *
     * @return void
     */
    public function testSeek()
    {
        $callbackStream = $this->getObjectForTest();
        $callbackStream->seek(1);
    }

    /**
     * Test rewind - there is no way how to rewind callback stream.
     * 
     * @expectedException \RuntimeException
     *
     * @return void
     */
    public function testRewind()
    {
        $callbackStream = $this->getObjectForTest();
        $callbackStream->rewind();
    }

    /**
     * Test if the stream is writable - callback stream is not writable.
     *
     * @return void
     */
    public function testIsWritable()
    {
        $callbackStream = $this->getObjectForTest();
        $this->assertFalse($callbackStream->isWritable());
    }

    /**
     * Test write into the stream - callback stream is not writable.
     *
     * @expectedException \RuntimeException
     *     
     * @return void
     */
    public function testWrite()
    {
        $callbackStream = $this->getObjectForTest();
        $callbackStream->write('test data');
    }

    /**
     * Test if the stream is readable - callback stream is not readable.
     *
     * @return void
     */
    public function testIsReadable()
    {
        $callbackStream = $this->getObjectForTest();
        $this->assertFalse($callbackStream->isReadable());
    }

    /**
     * Test read from the stream - there is no way how to read from the callback stream.
     *
     * @expectedException \RuntimeException
     *     
     * @return void
     */
    public function testRead()
    {
        $callbackStream = $this->getObjectForTest();
        $callbackStream->read(0);
    }

    /**
     * Test get content from the stream - execute callback and return its content.
     * 
     * @return void
     */
    public function testGetContents()
    {
        $callbackStream = $this->getObjectForTest();
        $this->assertEquals('test', $callbackStream->getContents());
    }

    /**
     * Test get metadata without any parameters - all metadata must be returned.
     * 
     * @return void
     */
    public function testGetMetadata()
    {
        $callbackStream = $this->getObjectForTest();
        $this->assertEquals(
            [
                'eof' => false,
                'stream_type' => 'callback',
                'seekable' => false,
            ],
            $callbackStream->getMetadata()
        );
    }

    /**
     * Test get metadata with parameter - only demanded metadata part will be
     * returned.
     * 
     * @return void
     */
    public function testGetMetadataParticular()
    {
        $callbackStream = $this->getObjectForTest();
        $this->assertEquals('callback', $callbackStream->getMetadata('stream_type'));
    }

    /**
     * Test get non existing metadata - null value will be returned.
     * 
     * @return void
     */
    public function testGetMetadataNonExistent()
    {
        $callbackStream = $this->getObjectForTest();
        $this->assertNull($callbackStream->getMetadata('foo'));
    }

    /**
     * Test typecasting instance into string.
     * 
     * @return void
     */
    public function testToString()
    {
        $callbackStream = $this->getObjectForTest();
        $this->assertEquals('test', (string)$callbackStream);
    }

    /**
     * Test typecasting instance into string - callback throw exception, 
     * this exception should not be propagate to __toString method.
     * 
     * @return void
     */
    public function testToStringException()
    {
        $callback = function () {
            throw new Exception('Test exception');
        };
        $callbackStream = new CallbackStream($callback);
        $this->assertEquals('', (string)$callbackStream);
    }

    /**
     * Get callback stream for the testing.
     *
     * @return CallbackStream
     */
    private function getObjectForTest()
    {
        $callback = function () {
            return 'test';
        };
        return new CallbackStream($callback);
    }
}
