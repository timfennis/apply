<?php

declare(strict_types=1);

namespace Apply\Collection;

use function Apply\Collection\Imperative\take;
use Codeception\Test\Unit;
use PHPUnit\Framework\TestCase;

class StringIteratorTest extends Unit
{
    // tests
    public function testWithTake5FromHelloWorld(): void
    {
        $string = take(new StringIterator('Hello World'), 5);

        TestCase::assertSame('Hello', implode('', iterator_to_array($string, false)));
    }
}
