<?php

namespace Apply\Collection;

use Codeception\Test\Unit;
use PHPUnit\Framework\TestCase;
use function Apply\Collection\Imperative\take;

class StringIteratorTest extends Unit
{


    // tests
    public function testWithTake5FromHelloWorld(): void
    {
        $string = take(new StringIterator('Hello World'), 5);

        TestCase::assertSame('Hello', implode('', iterator_to_array($string, false)));
    }
}
