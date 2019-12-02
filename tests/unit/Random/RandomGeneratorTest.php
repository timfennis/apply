<?php

declare(strict_types=1);

namespace unit\Random;

use Apply\Random\RandomGenerator;
use Codeception\Test\Unit;

class RandomGeneratorTest extends Unit
{
    public function testIt()
    {
        $generator = RandomGenerator::fromSeed(123);

        $referenceImplementation = new Mersenne_Twister(123);

        for ($i = 0; $i < 1000; ++$i) {
            [$generator, $value] = $generator->getNext();

            $this->assertSame($referenceImplementation->getNext(), $value);
        }
    }
}

/**
 * @internal Reference implementation we copied from
 */
class Mersenne_Twister
{
    private $state = [];
    private $index = 0;

    public function __construct($seed = null)
    {
        if (null === $seed) {
            $seed = mt_rand();
        }

        $this->setSeed($seed);
    }

    public function setSeed($seed)
    {
        $this->state[0] = $seed & 0xffffffff;

        for ($i = 1; $i < 624; ++$i) {
            $this->state[$i] = (((0x6c078965 * ($this->state[$i - 1] ^ ($this->state[$i - 1] >> 30))) + $i)) & 0xffffffff;
        }

        $this->index = 0;
    }

    private function generateTwister()
    {
        for ($i = 0; $i < 624; ++$i) {
            $y = (($this->state[$i] & 0x1) + ($this->state[$i] & 0x7fffffff)) & 0xffffffff;
            $this->state[$i] = ($this->state[($i + 397) % 624] ^ ($y >> 1)) & 0xffffffff;

            if (1 == ($y % 2)) {
                $this->state[$i] = ($this->state[$i] ^ 0x9908b0df) & 0xffffffff;
            }
        }
    }

    public function getNext($min = null, $max = null)
    {
        if ((null === $min && null !== $max) || (null !== $min && null === $max)) {
            throw new \Exception('Invalid arguments');
        }
        $y = $this->state[$this->index];
        $y = ($y ^ ($y >> 11)) & 0xffffffff;
        $y = ($y ^ (($y << 7) & 0x9d2c5680)) & 0xffffffff;
        $y = ($y ^ (($y << 15) & 0xefc60000)) & 0xffffffff;
        $y = ($y ^ ($y >> 18)) & 0xffffffff;

        $this->index = ($this->index + 1) % 624;

        if (0 === $this->index) {
            $this->generateTwister();
        }

        if (null === $min && null === $max) {
            return $y;
        }

        $range = abs($max - $min);

        return min($min, $max) + ($y % ($range + 1));
    }
}
