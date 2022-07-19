<?php

namespace jc21\TV;

use DateTime;
use Exception;
use JsonSerializable;
use jc21\Util\Item;
use jc21\Util\Duration;

/**
 * To represent a TV Show
 *
 * @property int $ratingKey
 * @property string $key
 * @property string $guid
 * @property string $studio
 * @property string $type
 * @property string $title
 * @property string $titleSort
 * @property int $episodeSort
 * @property string $contentRating
 * @property string $summary
 * @property int $index
 * @property string $audienceRating
 * @property int $viewCount
 * @property int $skipCount
 * @property DateTime $lastViewedAt
 * @property DateTime $addedAt
 * @property DateTime $updatedAt
 * @property int $year
 * @property string $thumb
 * @property string $art
 * @property Duration $duration
 * @property DateTime $originallyAvailableAt
 * @property int $leafCount
 * @property int $viewedLeafCount
 * @property int $childCount
 * @property string $audienceRatingImage
 * @property array $genre
 * @property array $role
 * @property array:Season $seasons
 */
class Show implements Item, JsonSerializable
{
    /**
     * Class data
     *
     * @var array
     */
    private array $data;

    /**
     * Array to store the seasons of this show
     *
     * @var array:Season
     */
    private array $seasons;

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
            'episodeSort' => null,
            'contentRating' => null,
            'summary' => null,
            'index' => null,
            'audienceRating' => null,
            'viewCount' => null,
            'skipCount' => null,
            'lastViewedAt' => null,
            'addedAt' => null,
            'updatedAt' => null,
            'year' => null,
            'thumb' => null,
            'art' => null,
            'duration' => new Duration(0),
            'originallyAvailableAt' => null,
            'leafCount' => null,
            'viewedLeafCount' => null,
            'childCount' => null,
            'audienceRatingImage' => null,
            'genre' => [],
            'role' => [],
        ];
        $this->seasons = [];
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
     * Method to get the seasons
     *
     * @return array:Season
     */
    public function getSeasons(): array
    {
        return $this->seasons;
    }

    /**
     * Method to add a season to the show
     *
     * @param Season $s
     *
     * @return bool
     */
    public function addSeason(Season $s)
    {
        if (!$s->index) {
            return false;
        }

        $this->seasons[$s->index] = $s;
        return true;
    }

    /**
     * Method to create an object from the library
     *
     * @param array $lib
     *
     * @return Show
     *
     * @throws Exception
     */
    public static function fromLibrary(array $lib): Show
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

        if (isset($lib['duration'])) {
            $me->duration = new Duration($lib['duration']);
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

        $res = $client->call($me->key);

        if (isset($res['Directory']) && is_array($res['Directory']) && count($res['Directory'])) {
            if (isset($res['Directory'][0])) {
                foreach ($res['Directory'] as $s) {
                    if ($s['title'] == 'All episodes') {
                        continue;
                    }

                    $season = Season::fromLibrary($s);
                    $me->addSeason($season);
                }
            } else {
                $season = Season::fromLibrary($res['Directory']);
                $me->addSeason($season);
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
