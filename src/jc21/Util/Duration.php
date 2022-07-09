<?php

namespace jc21\Util;

use JsonSerializable;

/**
 * Class to store the duration for conversion
 */
class Duration implements JsonSerializable
{
    /**
     * Class data
     */
    private int $duration;

    /**
     * Constructor
     *
     * @param int $duration
     */
    public function __construct(int $duration)
    {
        $this->duration = $duration;
    }

    /**
     * The duration represented in mins
     *
     * @return string
     */
    public function minutes(): string
    {
        return gmdate("i", (int)$this->duration / 1000);
    }

    /**
     * The duration represented in seconds
     *
     * @return string
     */
    public function seconds(): string
    {
        return (string)($this->duration / 1000);
    }

    /**
     * Method to convert the duration to seconds
     *
     * @return string
     */
    public function __toString(): string
    {
        return gmdate("H:i:s", (int)$this->duration / 1000);
    }

    /**
     * Method to serialize the object
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return (string) $this->duration;
    }
}
