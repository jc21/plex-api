<?php

namespace jc21\TV;

use DateTime;
use jc21\Media;
use jc21\Util\Duration;

/**
 * Class to store episode data
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
 * @property string $contentRating
 * @property string $summary
 * @property int $index
 * @property int $parentIndex
 * @property string $audienceRating
 * @property string $audienceRatingImage
 * @property int $viewCount
 * @property DateTime $lastViewedAt
 * @property string $thumb
 * @property string $parentThumb
 * @property string $grandparentThumb
 * @property string $art
 * @property string $grandparentArt
 * @property Duration $duration
 * @property DateTime $originallyAvailableAt
 * @property DateTime $addedAt
 * @property DateTime $updatedAt
 * @property Media $media
 */
class Episode
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
    public function __get(string $var)
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
     * Method to create an object from library data
     *
     * @param array $lib
     *
     * @return Episode
     */
    public static function fromLibrary(array $lib)
    {
        $me = new static();
        $me->data = $lib;

        if (isset($lib['lastViewedAt'])) {
            $lastViewedAt = new DateTime();
            $lastViewedAt->setTimestamp($lib['lastViewedAt']);
            $me->lastViewedAt = $lastViewedAt;
        }

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

        if (isset($lib['originallyAvailableAt'])) {
            $me->originallyAvailableAt = new DateTime($lib['originallyAvailableAt']);
        }

        if (isset($lib['Media']) && $lib['Media'] && count($lib['Media'])) {
            $me->media = Media::fromLibrary($lib['Media']);
        }

        if (isset($lib['Director']) && is_array($lib['Director'])) {
            if (count($lib['Director']) == 1) {
                $me->data['director'][] = $lib['Director']['tag'];
            } else {
                foreach ($lib['Director'] as $d) {
                    $me->data['director'][] = $d['tag'];
                }
            }
            unset($me->data['Director']);
        }

        if (isset($lib['Writer']) && is_array($lib['Writer'])) {
            if (count($lib['Writer']) == 1) {
                $me->data['writer'][] = $lib['Writer']['tag'];
            } else {
                foreach ($lib['Writer'] as $w) {
                    $me->data['writer'][] = $w['tag'];
                }
            }
            unset($me->data['Writer']);
        }

        if (isset($lib['Role']) && is_array($lib['Role'])) {
            if (count($lib['Role']) == 1) {
                $me->data['role'][] = $lib['Role']['tag'];
            } else {
                foreach ($lib['Role'] as $r) {
                    $me->data['role'][] = $r['tag'];
                }
            }
            unset($me->data['Role']);
        }

        unset($me->data['Media']);

        return $me;
    }
}
