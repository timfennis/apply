<?php

declare(strict_types=1);

namespace Test\Apply\Unit\Collection;

use function Apply\Collection\iteratorOf;
use Codeception\Test\Unit;

class IteratorOfTest extends Unit
{
    public function testIteratorOf()
    {
        $this->assertInstanceOf(\Iterator::class, iteratorOf([1, 2, 3, 4, 5, 6, 7, 8, 9]));
    }
}
