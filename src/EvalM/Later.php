<?php

declare(strict_types=1);

namespace Apply\EvalM;

class Later extends EvalM
{
    /** @var callable */
    private $callable;

    /** @var mixed */
    private $value;

    private bool $initialized = false;

    protected function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        if (!$this->initialized) {
            $this->initialized = true;
            $this->value = ($this->callable)();
        }

        return $this->value;
    }
}
