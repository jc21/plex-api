<?php

namespace jc21\Util;

use Exception;

/**
 * Class to act as a filter for queries
 */
class Filter
{
    /**
     * Variable to store the field for the filter
     *
     * @var string
     */
    private string $field;

    /**
     * Variable to store the operator for the action
     *
     * @var string
     */
    private string $operator;

    /**
     * Variable to store the value of the filter
     *
     * @var string
     */
    private string $value;

    /**
     * Constructor
     *
     * @param string $field
     * @param string $value
     * @param string $operator
     */
    public function __construct(string $field, string $value, string $operator = '=')
    {
        if (!in_array($operator, ['=', '!=', '>=', '<='])) {
            throw new Exception("Invalid filter operator");
        }

        if (!in_array($field, ['title', 'rating', 'contentRating', 'year', 'studio'])) {
            throw new Exception("Invalid filter field");
        }

        $this->field = $field;
        $this->operator = $operator;
        $this->value = $value;
    }

    /**
     * Method to make the object a string
     *
     * @return string
     */
    public function __toString()
    {
        $val = urlencode($this->value);
        return "{$this->field}{$this->operator}{$val}";
    }
}
