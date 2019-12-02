<?php

declare(strict_types=1);

namespace Apply\EvalM;

/**
 * Class Now.
 *
 * @property mixed $value
 */
class Now extends EvalM
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}
