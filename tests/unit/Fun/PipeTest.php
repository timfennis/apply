<?php

declare(strict_types=1);

namespace unit\Fun;


use Codeception\Test\Unit;
use function Apply\Fun\Imperative\pipeMany;

class PipeTest extends Unit
{
   public function testThatItPipesManyFunctionsInTheCorrectOrder()
   {
       $mul2 = fn($x) => $x * 2;
       $add5 = fn($x) => $x + 5;
       $sub10 = fn($x) => $x - 10;

       $result = pipeMany($mul2, $sub10, $mul2, $add5);

       $this->assertSame(45, $result(15));
   }
}