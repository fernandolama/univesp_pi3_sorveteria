<?php

use PHPUnit\Framework\TestCase;

class ExemploTest extends TestCase
{
    public function testSomaSimples()
    {
        $this->assertEquals(2 + 3, 5);
    }

    public function testValorNaoEhNegativo()
    {
        $valor = 10;
        $this->assertGreaterThanOrEqual(0, $valor);
    }
}
