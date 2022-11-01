<?php

namespace jc21\Util;

/**
 * Class to store size data
 */
class Size
{
    /**
     * Class data
     *
     * @var int
     */
    private int $size;

    /**
     * Constructor
     *
     * @param int $size (in bytes)
     */
    public function __construct(int $size)
    {
        $this->size = $size;
    }

    /**
     * Returns the size in TB
     * 
     * @return string
     */
    public function TB()
    {
        return number_format($this->size / 1024 / 1024 / 1024 / 1024, 3);
    }

    /**
     * Return the size in GB
     *
     * @return string
     */
    public function GB()
    {
        return number_format($this->size / 1024 / 1024 / 1024, 3);
    }

    /**
     * Return the size in MB
     *
     * @return string
     */
    public function MB()
    {
        return number_format($this->size / 1024 / 1024, 3);
    }

    /**
     * Return the size in KB
     *
     * @return string
     */
    public function KB()
    {
        return number_format($this->size / 1024, 3);
    }

    /**
     * Return the size in bytes
     *
     * @return int
     */
    public function bytes()
    {
        return $this->size;
    }
}
