<?php
namespace Kambo\Http\Stream;

// \Spl
use RuntimeException;
use Exception;

// \Psr
use Psr\Http\Message\StreamInterface;

/**
 * Describes a callback stream.
 *
 * It provides a stream wrapper around the provided callback.
 *
 * @package Kambo\Http\Stream
 * @author  Bohuslav Simek <bohuslav@simek.si>
 * @license MIT
 */
class CallbackStream implements StreamInterface
{
    /**
     * Stream callback
     *
     * @var callable|null
     */
    protected $callback;

    /**
     * Constructor - CallbackStream accept callback as an only parameter.
     *
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Closes the stream and null the callback.
     *
     * @return void
     */
    public function close()
    {
        $this->callback = null;
    }

    /**
     * Separates underline callback from the stream.
     *
     * After the stream has been detached, the stream is in an unusable state.
     *
     * @return callable|null Underlying callback, if any
     */
    public function detach()
    {
        $oldCallback    = $this->callback;
        $this->callback = null;

        return $oldCallback;
    }

    /**
     * Get the size of the stream if known.
     * Size of the callback stream is always unknown, thus a null value is returned.
     *
     * @return null Returns the size in bytes if known, or null if unknown.
     */
    public function getSize()
    {
        return null;
    }

    /**
     * Returns the current position of the file read/write pointer.
     * This is not supported for the callback stream.
     *
     * @return void
     *
     * @throws \RuntimeException on error.
     */
    public function tell()
    {
        throw new RuntimeException('Callback stream do not provide current position');
    }

    /**
     * Returns true if the stream is at the end of the stream.
     *
     * @return bool
     */
    public function eof()
    {
        return empty($this->callback);
    }

    /**
     * Returns whether or not the stream is seekable.
     * The callback stream is not seekable.
     *
     * @return bool 
     */
    public function isSeekable()
    {
        return false;
    }

    /**
     * Seek to a position in the stream.
     * The callback stream is not seekable, this method will raise an exception.
     *
     * @link http://www.php.net/manual/en/function.fseek.php
     *
     * @param int $offset Stream offset
     * @param int $whence Specifies how the cursor position will be calculated
     *                    based on the seek offset. Valid values are identical to the built-in
     *                    PHP $whence values for `fseek()`.  SEEK_SET: Set position equal to
     *                    offset bytes SEEK_CUR: Set position to current location plus offset
     *                    SEEK_END: Set position to end-of-stream plus offset.
     *
     * @return void
     *
     * @throws \RuntimeException on failure.
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        throw new RuntimeException('Cannot seek in callback stream');
    }

    /**
     * Seek to the beginning of the stream.
     * The callback stream is not seekable, this method will raise an exception.
     *
     * @see seek()
     * @link http://www.php.net/manual/en/function.fseek.php
     *
     * @return void
     *
     * @throws \RuntimeException on failure.
     */
    public function rewind()
    {
        throw new RuntimeException('Cannot rewind callback stream');
    }

    /**
     * Returns whether or not the stream is writable.
     * The callback stream is not writable, this method will raise an exception.
     *
     * @return bool
     */
    public function isWritable()
    {
        return false;
    }

    /**
     * Write data to the stream.
     * The callback stream is not writable, this method will raise an exception.
     *
     * @param string $string The string that is to be written.
     *
     * @return void
     *
     * @throws \RuntimeException on failure.
     */
    public function write($string)
    {
        throw new RuntimeException('Cannot write into callback stream');
    }

    /**
     * Returns whether or not the stream is readable.
     * The callback stream is not readable.
     *
     * @return bool
     */
    public function isReadable()
    {
        return false;
    }

    /**
     * Read data from the stream.
     * The callback stream is not readable, this method will raise an exception.
     *
     * @param int $length Read up to $length bytes from the object and return
     *                    them. Fewer than $length bytes may be returned if underlying stream
     *                    call returns fewer bytes.
     *
     * @return string Returns the data read from the stream, or an empty string
     *                if no bytes are available.
     *
     * @throws \RuntimeException if an error occurs.
     */
    public function read($length)
    {
        throw new RuntimeException('Cannot read in callback stream');
    }

    /**
     * Execute callback function and return its content as a string.
     *
     * @return string
     *
     * @throws \RuntimeException if unable to read or an error occurs while reading.
     */
    public function getContents()
    {
        $callback = $this->detach();
        return $callback ? $callback() : '';
    }

    /**
     * Get stream metadata as an associative array or retrieve a specific key.
     *
     * The keys returned are same to the keys returned from PHP's
     * stream_get_meta_data() function.
     *
     * @link http://php.net/manual/en/function.stream-get-meta-data.php
     *
     * @param string $key Specific metadata to retrieve.
     *
     * @return array|mixed|null Returns an associative array if no key is provided.
     *                          Returns a specific key value if a key is provided and the
     *                          value is found, or null if the key is not found.
     */
    public function getMetadata($key = null)
    {
        $metadata = [
            'eof' => $this->eof(),
            'stream_type' => 'callback',
            'seekable' => false
        ];

        if (is_null($key) === true) {
            return $metadata;
        }

        return isset($metadata[$key]) ? $metadata[$key] : null;
    }

    /**
     * Execute callback function and return its content as a string.
     *
     * This method does not raise an exception in order to conform with PHP's
     * string casting operations.
     *
     * @see http://php.net/manual/en/language.oop5.magic.php#object.tostring
     *
     * @return string
     */
    public function __toString()
    {
        try {
            return $this->getContents();
        } catch (Exception $e) {
            return '';
        }
    }
}
