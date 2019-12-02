<?php

declare(strict_types=1);

namespace Apply\Random;

/**
 * @internal
 */
class Twister
{
    /** @var array */
    private array $state;

    private function __construct(array $state)
    {
        $this->state = $state;
    }

    public function get(int $i)
    {
        return $this->state[$i];
    }

    public static function fromSeed($seed): Twister
    {
        $state[0] = $seed & 0xffffffff;

        for ($i = 1; $i < 624; ++$i) {
            $state[$i] = (((0x6c078965 * ($state[$i - 1] ^ ($state[$i - 1] >> 30))) + $i)) & 0xffffffff;
        }

        return new self($state);
    }

    public static function generate(Twister $twister): Twister
    {
        $state = $twister->state;
        for ($i = 0; $i < 624; ++$i) {
            $y = (($state[$i] & 0x1) + ($state[$i] & 0x7fffffff)) & 0xffffffff;
            $state[$i] = ($state[($i + 397) % 624] ^ ($y >> 1)) & 0xffffffff;

            if (1 == ($y % 2)) {
                $state[$i] = ($state[$i] ^ 0x9908b0df) & 0xffffffff;
            }
        }

        return new self($state);
    }
}

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
