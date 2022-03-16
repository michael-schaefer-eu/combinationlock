<?php declare(strict_types=1);

namespace Unit\CombinationLock\CodeGenerator;

use App\CombinationLock\CodeGenerator\SimpleCodeGenerator;
use PHPUnit\Framework\TestCase;

final class SimpleCodeGeneratorTest extends TestCase
{
    public function testGenerateCodesLengthOne(): void
    {
        $generator = new SimpleCodeGenerator();
        $codes = $generator->generate(1);

        $this->assertCount(10, $codes);
        $this->assertEquals('0', $codes[0]);
        $this->assertEquals('7', $codes[7]);
    }

    public function testGenerateCodesLengthTwo(): void
    {
        $generator = new SimpleCodeGenerator();
        $codes = $generator->generate(2);

        $this->assertCount(100, $codes);
        $this->assertEquals('00', $codes[0]);
        $this->assertEquals('07', $codes[7]);
        $this->assertEquals('11', $codes[11]);
        $this->assertEquals('99', $codes[99]);
    }

    public function testGenerateCodesLengthNine(): void
    {
        $generator = new SimpleCodeGenerator();
        $codes = $generator->generate(5);

        $this->assertCount(100000, $codes);
        $this->assertEquals('00000', $codes[0]);
        $this->assertEquals('00007', $codes[7]);
        $this->assertEquals('12345', $codes[12345]);
        $this->assertEquals('99999', $codes[99999]);
    }
}
