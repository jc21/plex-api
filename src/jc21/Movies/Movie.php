<?php

namespace jc21\Movies;

use DateTime;
use JsonSerializable;

use jc21\Util\Item;
use jc21\Util\Media;
use jc21\Util\Duration;

/**
 * Object to be a movie
 *
 * @property int $ratingKey
 * @property string $key
 * @property string $guid
 * @property string $studio
 * @property string $type
 * @property string $title
 * @property string $titleSort
 * @property string $contentRating
 * @property string $summery
 * @property string $audienceRating
 * @property int $viewCount
 * @property DateTime $lastViewedAt
 * @property int $year
 * @property string $tagline
 * @property string $thumb
 * @property string $art
 * @property Duration $duration
 * @property DateTime $originallyAvailableAt
 * @property DateTime $addedAt
 * @property DateTime $updatedAt
 * @property string $audienceRatingImage
 * @property string $primaryExtraKey
 * @property array $genre
 * @property array $director
 * @property array $writer
 * @property array $country
 * @property array $role
 * @property Media $media
 */
class Movie implements JsonSerializable, Item
{
    /**
     * Class data
     *
     * @var array
     */
    private array $data;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = [
            'ratingKey' => null,
            'key' => null,
            'guid' => null,
            'studio' => null,
            'type' => null,
            'title' => null,
            'titleSort' => null,
            'contentRating' => null,
            'summery' => null,
            'audienceRating' => null,
            'viewCount' => null,
            'lastViewedAt' => null,
            'year' => null,
            'tagline' => null,
            'thumb' => null,
            'art' => null,
            'duration' => null,
            'originallyAvailableAt' => null,
            'addedAt' => null,
            'updatedAt' => null,
            'audienceRatingImage' => null,
            'primaryExtraKey' => null,
            'media' => null,
            'genre' => [],
            'director' => [],
            'writer' => [],
            'country' => [],
            'role' => [],
        ];
    }

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
     * Method to create an object from a library
     *
     * @param array $library
     *
     * @return Movie
     */
    public static function fromLibrary(array $library): Movie
    {
        $me = new static();
        $me->data = $library;

        if (isset($library['duration'])) {
            $me->duration = new Duration($library['duration']);
        }

        if (isset($library['lastViewedAt'])) {
            $lastViewedAt = new DateTime();
            $lastViewedAt->setTimestamp($library['lastViewedAt']);
            $me->lastViewedAt = $lastViewedAt;
        }

        $addedAt = new DateTime();
        $addedAt->setTimestamp($library['addedAt']);
        $me->addedAt = $addedAt;

        $updatedAt = new DateTime();
        $updatedAt->setTimestamp($library['updatedAt']);
        $me->updatedAt = $updatedAt;

        if (isset($library['originallyAvailableAt'])) {
            $me->originallyAvailableAt = new DateTime($library['originallyAvailableAt']);
        }

        if (isset($library['Genre']) && is_array($library['Genre'])) {
            if (count($library['Genre']) == 1) {
                $me->data['genre'][] = $library['Genre']['tag'];
            } else {
                foreach ($library['Genre'] as $g) {
                    $me->data['genre'][] = $g['tag'];
                }
            }
            unset($me->data['Genre']);
        }

        if (isset($library['Director']) && is_array($library['Director'])) {
            if (count($library['Director']) == 1) {
                $me->data['director'][] = $library['Director']['tag'];
            } else {
                foreach ($library['Director'] as $d) {
                    $me->data['director'][] = $d['tag'];
                }
            }
            unset($me->data['Director']);
        }

        if (isset($library['Writer']) && is_array($library['Writer'])) {
            if (count($library['Writer']) == 1) {
                $me->data['writer'][] = $library['Writer']['tag'];
            } else {
                foreach ($library['Writer'] as $w) {
                    $me->data['writer'][] = $w['tag'];
                }
            }
            unset($me->data['Writer']);
        }

        if (isset($library['Role']) && is_array($library['Role'])) {
            if (count($library['Role']) == 1) {
                $me->data['role'][] = $library['Role']['tag'];
            } else {
                foreach ($library['Role'] as $r) {
                    $me->data['role'][] = $r['tag'];
                }
            }
            unset($me->data['Role']);
        }

        if (isset($library['Media'])) {
            if (isset($library['Media'][0])) {
                $arr = [];
                foreach ($library['Media'] as $m) {
                    $media = Media::fromLibrary($m);
                    $arr[] = $media;
                }
                $me->media = $arr;
            } else {
                $media = Media::fromLibrary($library['Media']);
                $me->media = $media;
            }
            unset($me->data['Media']);
        }

        if (isset($library['Collection'])) {
            $col = [];
            if (count($library['Collection']) == 1) {
                $col[] = $library['Collection']['tag'];
            } else {
                foreach ($library['Collection'] as $c) {
                    $col[] = $c['tag'];
                }
            }
            $me->collection = $col;
            unset($me->data['Collection']);
        }

        unset($me->data['Country']);

        return $me;
    }

    /**
     * Method to serialize the object
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->data;
    }
}
