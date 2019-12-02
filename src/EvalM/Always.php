<?php

declare(strict_types=1);

namespace Apply\EvalM;

class Always extends EvalM
{
    /** @var callable */
    private $callable;

    protected function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return ($this->callable)();
    }
}
