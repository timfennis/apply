<?php


namespace Apply\EvalM;

abstract class FlatMap extends EvalM
{
    abstract public function start(): EvalM;

    /**
     *
     * @param callable $s
     *
     * @return EvalM
     *
     * @template S
     * @phan-param callable(S): EvalM<B> $s
     */
    abstract public function run($s): EvalM;

    public function value()
    {
        return EvalM::evaluate($this);
    }
}
