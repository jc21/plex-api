<?php

namespace jc21;

use DateTime;
use JsonSerializable;

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
     * Method to create an object from library data
     *
     * @param array $section
     *
     * @return Section
     */
    public static function fromLibrary($section): self
    {
        $me = new static();

        $me->data = $section;

        $me->libraryType = 'public';
        if ($me->agent == PlexApi::PLEX_AGENT_NONE) {
            $me->libraryType = 'personal';
        }

        $createdAt = new DateTime();
        $createdAt->setTimestamp($section['createdAt']);
        $me->createdAt = $createdAt;

        $updatedAt = new DateTime();
        $updatedAt->setTimestamp($section['updatedAt']);
        $me->updatedAt = $updatedAt;
        
        $scannedAt = new DateTime();
        $scannedAt->setTimestamp($section['scannedAt']);
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
