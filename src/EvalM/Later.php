<?php


namespace Apply\EvalM;

class Later extends EvalM
{
    /** @var callable */
    private $callable;

    /** @var mixed */
    private $value;

    /** @var bool */
    private $initialized = false;

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
