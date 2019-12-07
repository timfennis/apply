<?php

declare(strict_types=1);

namespace Apply\Random;

class RandomGenerator
{
    private Twister $twister;

    private int $index;

    private function __construct(Twister $twister, int $index)
    {
        $this->twister = $twister;
        $this->index = $index;
    }

    public function getNext()
    {
        $y = $this->twister->get($this->index);
        $y = ($y ^ ($y >> 11)) & 0xffffffff;
        $y = ($y ^ (($y << 7) & 0x9d2c5680)) & 0xffffffff;
        $y = ($y ^ (($y << 15) & 0xefc60000)) & 0xffffffff;
        $y = ($y ^ ($y >> 18)) & 0xffffffff;

        $nextIndex = ($this->index + 1) % 624;

        $nextTwister = 0 === $nextIndex
            ? Twister::generate($this->twister)
            : $this->twister;

        return [new RandomGenerator($nextTwister, $nextIndex), $y];
    }

    public static function fromSeed($seed): RandomGenerator
    {
        return new RandomGenerator(Twister::fromSeed($seed), 0);
    }
}
