<?php

namespace jc21\Music;

use DateTime;
use Exception;
use JsonSerializable;
use jc21\Collections\ItemCollection;
use jc21\Util\Item;

/**
 * Album data
 *
 * @property int $ratingKey
 * @property int $parentRatingKey
 * @property string $key
 * @property string $parentKey
 * @property string $guid
 * @property string $parentGuid
 * @property string $studio
 * @property string $type
 * @property string $title
 * @property string $titleSort
 * @property string $parentTitle
 * @property string $summary
 * @property string $rating
 * @property int $index
 * @property int $viewCount
 * @property int $skipCount
 * @property DateTime $lastViewedAt
 * @property int $year
 * @property string $thumb
 * @property string $parentThumb
 * @property DateTime $originallyAvailableAt
 * @property DateTime $addedAt
 * @property DateTime $updatedAt
 * @property int $loudnessAnalysisVersion
 * @property array $directory
 * @property array $genre
 */
class Album implements Item, JsonSerializable
{
    /**
     * Class data
     *
     * @var array
     */
    private array $data;

    /**
     * Array to store track data
     *
     * @var ItemCollection
     */
    private ItemCollection $tracks;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tracks = new ItemCollection();
    }

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
     * Method to retrieve tracks on this album
     * 
     * @return ItemCollection
     */
    public function getChildren(): ItemCollection
    {
        return $this->tracks;
    }

    /**
     * Add a track to the library
     *
     * @param Track $t
     */
    public function addTrack(Track $t)
    {
        $this->tracks->addData($t);
    }

    /**
     * Method to create an object from Plex data
     *
     * @param array $lib
     *
     * @return Album
     */
    public static function fromLibrary(array $lib): Album
    {
        if (!isset($GLOBALS['client'])) {
            throw new Exception('PlexApi client `$client` not available');
        }
        global $client;

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

        if (isset($lib['originallyAvailableAt'])) {
            $me->originallyAvailableAt = new DateTime($lib['originallyAvailableAt']);
        }

        if (isset($lib['Genre']) && is_array($lib['Genre'])) {
            if (count($lib['Genre']) == 1) {
                $me->data['genre'][] = $lib['Genre']['tag'];
            } else {
                foreach ($lib['Genre'] as $g) {
                    $me->data['genre'][] = $g['tag'];
                }
            }
            unset($me->data['Genre']);
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

        $res = $client->call($me->key);
        if (isset($res['Track']) && is_array($res['Track']) && count($res['Track'])) {
            if (isset($res['Track'][0])) {
                foreach ($res['Track'] as $t) {
                    $track = Track::fromLibrary($t);
                    $me->addTrack($track);
                }
            } else {
                $track = Track::fromLibrary($res['Track']);
                $me->addTrack($track);
            }
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
