<?php

namespace jc21;

use DateTime;
use JsonSerializable;
use jc21\Util\Location;

/**
 * Object to store section info
 *
 * @property bool $allowSync
 * @property string $art
 * @property string $composite
 * @property bool $filters
 * @property bool $refreshing
 * @property string $thumb
 * @property int $key
 * @property string $libraryType
 * @property string $type
 * @property string $title
 * @property string $agent
 * @property string $scanner
 * @property string $language
 * @property string $uuid
 * @property DateTime $createdAt
 * @property DateTime $updatedAt
 * @property DateTime $scannedAt
 * @property int $content
 * @property int $directory
 * @property int $contentChangedAt
 * @property bool $hidden
 * @property Location $location
 */
class Section implements JsonSerializable
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
            'allowSync' => false,
            'art' => null,
            'composite' => null,
            'filters' => false,
            'refreshing' => false,
            'thumb' => null,
            'key' => null,
            'libraryType' => null,
            'type' => null,
            'title' => null,
            'agent' => null,
            'scanner' => null,
            'language' => null,
            'uuid' => null,
            'createdAt' => null,
            'updatedAt' => null,
            'scannedAt' => null,
            'content' => null,
            'directory' => null,
            'contentChangedAt' => null,
            'hidden' => false,
            'location' => new Location(),
        ];
    }

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
     * Method to create an object from library data
     *
     * @param array $lib
     *
     * @return Section
     */
    public static function fromLibrary(array $lib): self
    {
        $me = new static();

        $me->data = $lib;
        $me->allowSync = (bool) $lib['allowSync'];
        $me->hidden = (bool) $lib['hidden'];
        $me->filters = (bool) $lib['filters'];
        $me->refreshing = (bool) $lib['refreshing'];
        $me->location = Location::fromLibrary($lib['Location']);

        unset($me->data['Location']);

        $me->libraryType = 'public';
        if ($me->agent == PlexApi::PLEX_AGENT_NONE) {
            $me->libraryType = 'personal';
        }

        $createdAt = new DateTime();
        $createdAt->setTimestamp($lib['createdAt']);
        $me->createdAt = $createdAt;

        $updatedAt = new DateTime();
        $updatedAt->setTimestamp($lib['updatedAt']);
        $me->updatedAt = $updatedAt;
        
        $scannedAt = new DateTime();
        $scannedAt->setTimestamp($lib['scannedAt']);
        $me->scannedAt = $scannedAt;

        return $me;
    }

    /**
     * Method to serialize the object into json
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return $this->data;
    }
}
