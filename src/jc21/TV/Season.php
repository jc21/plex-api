<?php

namespace jc21\TV;

use DateTime;
use JsonSerializable;
use jc21\Collections\ItemCollection;
use jc21\PlexApi;

/**
 * To represent a season of a TV Show
 *
 * @property int $ratingKey
 * @property string $key
 * @property int $parentRatingKey
 * @property string $guid
 * @property string $parentGuid
 * @property string $parentStudio
 * @property string $type
 * @property string $title
 * @property string $parentKey
 * @property string $parentTitle
 * @property string $summary
 * @property int $index
 * @property int $parentYear
 * @property string $thumb
 * @property string $art
 * @property string $parentThumb
 * @property string $parentTheme
 * @property int $leafCount
 * @property int $viewedLeafCount
 * @property DateTime $addedAt
 * @property DateTime $updatedAt
 * @property array:Episode $episodes
 */
class Season implements JsonSerializable
{
    /**
     * Class data
     *
     * @var array
     */
    private array $data;

    /**
     * Array to store episodes of a show in a season
     *
     * @var ItemCollection
     */
    private ItemCollection $episodes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = [
            'ratingKey' => null,
            'key' => null,
            'parentRatingKey' => null,
            'guid' => null,
            'parentGuid' => null,
            'parentStudio' => null,
            'type' => null,
            'title' => null,
            'parentKey' => null,
            'parentTitle' => null,
            'summary' => null,
            'index' => null,
            'parentYear' => null,
            'thumb' => null,
            'art' => null,
            'parentThumb' => null,
            'parentTheme' => null,
            'leafCount' => null,
            'viewedLeafCount' => null,
            'addedAt' => null,
            'updatedAt' => null,
        ];
        $this->episodes = [];
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
     * Method to return the episodes
     *
     * @return ItemCollection
     */
    public function getChildren(): ItemCollection
    {
        return $this->episodes;
    }

    /**
     * Method to add an episode to the season
     *
     * @param Episode $e
     */
    public function addEpisode(Episode $e)
    {
        $this->episodes[$e->index] = $e;
    }

    /**
     * Method to create an object from the library
     *
     * @param array $lib
     *
     * @return Season
     */
    public static function fromLibrary(array $lib)
    {
        global $client;

        $me = new static();
        $me->data = $lib;

        $addedAt = new DateTime();
        $addedAt->setTimestamp($lib['addedAt']);
        $me->addedAt = $addedAt;

        $updatedAt = new DateTime();
        $updatedAt->setTimestamp($lib['updatedAt']);
        $me->updatedAt = $updatedAt;

        $res = $client->call($me->key);

        if (isset($res['Video']) && is_array($res['Video']) && count($res['Video'])) {
            if (isset($res['Video'][0])) {
                foreach ($res['Video'] as $e) {
                    $episode = Episode::fromLibrary($e);
                    $me->addEpisode($episode);
                }
            } else {
                $episode = Episode::fromLibrary($res['Video']);
                $me->addEpisode($episode);
            }
        }

        return $me;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return $this->data;
    }
}
