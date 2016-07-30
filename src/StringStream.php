<?php
namespace Kambo\Http\Stream;

// \Spl
use RuntimeException;
use Exception;

// \Psr
use Psr\Http\Message\StreamInterface;

// \Http\Message
use Kambo\Http\Message\Stream;

/**
 * Describes a data stream, instantiate using string.
 *
 * It provides a wrapper around the most common operations, including serialization of
 * the entire stream to a string.
 *
 * @package Kambo\Http\Stream
 * @author  Bohuslav Simek <bohuslav@simek.si>
 * @license MIT
 */
class StringStream extends Stream
{
    /**
     * Constructor
     *
     * @param string $content
     */
    public function __construct($content)
    {
        $stringResource = fopen('php://temp', 'r+');
        fwrite($stringResource, $content);
        rewind($stringResource);
        parent::__construct($stringResource);
    }
}
