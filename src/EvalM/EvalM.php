<?php


namespace Apply\EvalM;

class EvalM
{
    /** @var callable */
    private $callable;

    /** @var array */
    private $arguments;

    public function __construct(callable $callable, array $arguments = [])
    {
        $this->callable = $callable;
        $this->arguments = $arguments;
    }

    public function map(callable $fn): EvalM
    {
        return new self(function () use ($fn) {
            return $fn($this());
        });
    }

    public function flatMap(callable $fn): EvalM
    {
        return new self(function () use ($fn) {
            return $fn($this())();
        });
    }



    public function __invoke()
    {
        return ($this->callable)(...$this->arguments);
    }
}
