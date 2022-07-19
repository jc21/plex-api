<?php

namespace jc21\Util;

use JsonSerializable;

/**
 * Object to store Location info
 */
class Location implements JsonSerializable
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
     * Method to create a Location from the library data
     *
     * @param array $location
     *
     * @return Location
     */
    public static function fromLibrary(array $location): self
    {
        $me = new static();

        $me->data = $location;

        return $me;
    }

    /**
     * Method to serialize the object
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return $this->data;
    }
}
