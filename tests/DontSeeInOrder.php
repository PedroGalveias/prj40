<?php

namespace Tests;

use Illuminate\Foundation\Testing\Constraints\ReflectionClass;
use PHPUnit\Framework\Constraint\Constraint;

class DontSeeInOrder extends Constraint
{
    /**
     * The string under validation.
     *
     * @var string
     */
    protected $content;

    /**
     * The last value that failed to pass validation.
     *
     * @var string
     */
    protected $failedValue;


    protected $allValues = "";
    /**
     * Create a new constraint instance.
     *
     * @param  string  $content
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Determine if the rule passes validation.
     *
     * @param  array  $values
     * @return bool
     */
    public function matches($values) : bool // Inverso de SeeInOrder
    {
        $position = 0;
        $this->allValues = "";
        foreach ($values as $value) {
            if (empty($value)) {
                continue;
            }
            $this->allValues.= $value. "  |  ";

            $valuePosition = mb_strpos($this->content, $value, $position);

            if ($valuePosition === false || $valuePosition < $position) {
                return true;
            }

            $position = $valuePosition + mb_strlen($value);
        }

        return false;
    }

    /**
     * Get the description of the failure.
     *
     * @param  array  $values
     * @return string
     */
    public function failureDescription($values) : string
    {
        return sprintf(
            'Failed asserting that \'%s\' does not contains "%s" in specified order.',
            $this->content,
            $this->allValues            
        );
    }

    /**
     * Get a string representation of the object.
     *
     * @return string
     */
    public function toString() : string
    {
        return (new ReflectionClass($this))->name;
    }
}
