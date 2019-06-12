<?php


namespace Apply\TryM;


use Throwable;

final class Failure extends TryM
{
    /** @var Throwable */
    private $error;

    public function __construct(Throwable $error)
    {
        $this->error = $error;
    }
}