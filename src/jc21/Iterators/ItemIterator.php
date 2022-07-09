<?php

namespace jc21\Iterators;

use Iterator;
use jc21\Collections\ItemCollection;
use jc21\Util\Item;

/**
 * Iterator for the ItemCollection
 */
class ItemIterator implements Iterator
{
    /**
     * Position of the iterator
     *
     * @var int
     */
    private int $position = 0;

    /**
     * Collection in the iterator
     *
     * @var ItemCollection
     */
    private ItemCollection $collection;

    /**
     * Constructor
     *
     * @param ItemCollection $collection
     */
    public function __construct(ItemCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Method to return the current key position
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Method to return the current Item
     *
     * @return Item
     */
    public function current()
    {
        return $this->collection->getData($this->position);
    }

    /**
     * Method to increment the iterator
     */
    public function next(): void
    {
        $this->position++;
    }

    /**
     * Method to rewind the iterator
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * Method to check if the current position contains an object
     *
     * @return bool
     */
    public function valid(): bool
    {
        return !is_null($this->collection->getData($this->position));
    }
}
