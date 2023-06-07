<?php

namespace jc21\Music;

use DateTime;
use Exception;
use JsonSerializable;
use jc21\Util\Item;
use jc21\Collections\ItemCollection;

/**
 * Artist
 *
 * @property int $ratingKey
 * @property string $key
 * @property string $guid
 * @property string $type
 * @property string $title
 * @property string $summary
 * @property int $index
 * @property int $viewCount
 * @property int $skipCount
 * @property DateTime $lastViewedAt
 * @property DateTime $addedAt
 * @property DateTime $updatedAt
 * @property string $thumb
 * @property string $art
 * @property array $genre
 * @property array $country
 */
class Artist implements Item, JsonSerializable
{
    /**
     * Class data
     *
     * @var array
     */
    private array $data;

    /**
     * Array to store albums
     *
     * @var ItemCollection
     */
    private ItemCollection $albums;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->albums = new ItemCollection();
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
     * Method to retrieve the albums this artist has released
     * 
     * @return ItemCollection
     */
    public function getChildren(): ItemCollection
    {
        return $this->albums;
    }

    /**
     * Method to add album
     *
     * @param Album $a
     */
    public function addAlbum(Album $a)
    {
        $this->albums->addData($a);
    }

    /**
     * Method to create an object from a library
     *
     * @param array $lib
     *
     * @return Artist
     */
    public static function fromLibrary(array $lib): Artist
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

        unset($me->data['Country']);

        $res = $client->call($me->key);
        if (isset($res['Directory']) && is_array($res['Directory']) && count($res['Directory'])) {
            if (isset($res['Directory'][0])) {
                foreach ($res['Directory'] as $a) {
                    $a = Album::fromLibrary($a);
                    $me->addAlbum($a);
                }
            } else {
                $a = Album::fromLibrary($res['Directory']);
                $me->addAlbum($a);
            }
        }

        return $me;
    }

    /**
     * Serialize the object
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->data;
    }
}
