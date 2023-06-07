<?php

namespace jc21\Music;

use DateTime;
use JsonSerializable;
use jc21\Util\Duration;
use jc21\Util\Item;
use jc21\Util\Media;

/**
 * Music track data
 *
 * @property int $ratingKey
 * @property int $parentRatingKey
 * @property int $grandparentRatingKey
 * @property string $key
 * @property string $parentKey
 * @property string $grandparentKey
 * @property string $guid
 * @property string $parentGuid
 * @property string $grandparentGuid
 * @property string $type
 * @property string $title
 * @property string $parentTitle
 * @property string $grandparentTitle
 * @property string $parentStudio
 * @property string $summary
 * @property int $index
 * @property int $parentIndex
 * @property int $ratingCount
 * @property int $parentYear
 * @property string $thumb
 * @property string $parentThumb
 * @property string $grandparentThumb
 * @property Duration $duration
 * @property DateTime $addedAt
 * @property DateTime $updatedAt
 * @property Media $media
 */
class Track implements Item, JsonSerializable
{
    /**
     * Class data
     *
     * @var array
     */
    private array $data;

    /**
     * Magic getter
     *
     * @param string $var
     *
     * @return mixed
     */
    public function __get(string $var)
    {
        if (isset($this->data[$var])) {
            return $this->data[$var];
        }
        return null;
    }

    /**
     * Magic setter
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
     * @param array $lib
     *
     * @return Track
     */
    public static function fromLibrary(array $lib): Track
    {
        $me = new static();
        $me->data = $lib;

        if (isset($lib['addedAt'])) {
            $addedAt = new DateTime();
            $addedAt->setTimestamp($lib['addedAt']);
            $me->addedAt = $addedAt;
        }

        if (isset($lib['updatedAt'])) {
            $updatedAt = new DateTime();
            $updatedAt->setTimestamp($lib['updatedAt']);
            $me->updatedAt = $updatedAt;
        }

        if (isset($lib['duration'])) {
            $me->duration = new Duration($lib['duration']);
        }

        if (isset($lib['Media'])) {
            $me->media = Media::fromLibrary($lib['Media']);
            unset($lib['Media']);
        }

        return $me;
    }

    /**
     * Method to serialize the object
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->data;
    }
}
