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
        return (string) $this;
    }
}
