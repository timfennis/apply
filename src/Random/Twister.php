<?php

declare(strict_types=1);

namespace Apply\Random;

use JetBrains\PhpStorm\Pure;

/**
 * @internal
 */
class Twister
{
    private array $state;

    private function __construct(array $state)
    {
        $this->state = $state;
    }

    public function get(int $i)
    {
        return $this->state[$i];
    }

    #[Pure]
    public static function fromSeed($seed): Twister
    {
        $state[0] = $seed & 0xffffffff;

        for ($i = 1; $i < 624; ++$i) {
            $state[$i] = (((0x6c078965 * ($state[$i - 1] ^ ($state[$i - 1] >> 30))) + $i)) & 0xffffffff;
        }

        return new self($state);
    }

    #[Pure]
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
