<?php

namespace jc21\Util;

use JsonSerializable;
use jc21\Util\Duration;
use jc21\Util\Size;

/**
 * Class to store media info
 *
 * @property int $id
 * @property Duration $duration
 * @property int $bitrate
 * @property int $width
 * @property int $height
 * @property float $aspectRatio
 * @property int $audioChannels
 * @property string $audioCodec
 * @property string $videoCodec
 * @property string $videoResolution
 * @property string $videoFrameRate
 * @property bool $optomizedForStreaming
 * @property string $audioProfile
 * @property bool $has64bitOffsets
 * @property string $videoProfile
 * @property string $title
 * @property Size $size
 * @property string $path
 */
class Media implements JsonSerializable
{
    /**
     * Class data
     *
     * @var array
     */
    private array $data;

    /**
     * Magic getter method
     *
     * @param string $var
     *
     * @return mixed
     */
    public function __get(string $var): mixed
    {
        if (isset($this->data[$var])) {
            return $this->data[$var];
        }

        return null;
    }

    /**
     * Magic setter method
     *
     * @param string $var
     * @param mixed $val
     */
    public function __set(string $var, $val)
    {
        $this->data[$var] = $val;
    }

    /**
     * Method to create an object from the library
     *
     * @param array $library
     *
     * @return Media
     */
    public static function fromLibrary(array $library): Media
    {
        $me = new static();
        $me->data = $library;

        if (isset($library['duration'])) {
            $me->duration = new Duration($library['duration']);
        }

        if (isset($library['Part'])) {
            if (isset($library['Part']['size']) && $library['Part']['size'] > 0) {
                $me->size = new Size($library['Part']['size']);
            }
            if (isset($library['Part']['file'])) {
                $me->path = $library['Part']['file'];
            }
        }

        unset($me->data['Part']);

        return $me;
    }

    /**
     * Method to serialize the object
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return $this->data;
    }
}
