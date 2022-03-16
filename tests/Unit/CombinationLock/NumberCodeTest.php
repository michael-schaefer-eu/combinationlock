<?php declare(strict_types=1);

namespace Unit\CombinationLock;

use App\CombinationLock\NumberCode;
use PHPUnit\Framework\TestCase;

final class NumberCodeTest extends TestCase
{
    /**
     * @dataProvider createValidData
     */
    public function testCreateObjectWithValidData(array $code): void
    {
        $numberCode = new NumberCode($code);
        $this->assertInstanceOf(NumberCode::class, $numberCode);
    }

    public function createValidData(): \Generator
    {
        yield [[0]];
        yield [[1,1,1]];
        yield [[1,2,3,4,5,6,7,8,9]];
    }

    /**
     * @dataProvider createInvalidData
     */
    public function testCreateObjectWithInvalidData(array $code): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $numberCode = new NumberCode($code);
    }

    public function createInvalidData(): \Generator
    {
        yield [[]];
        yield [[10]];
        yield [['1']];
        yield [[1, '2']];
        yield [[1, 3.5]];
        yield [[new \stdClass()]];
    }

    /**
     * @dataProvider createValidDataWithString
     */
    public function testCodeToString(array $code, string $expected): void
    {
        $numberCode = new NumberCode($code);
        $this->assertEquals($expected, (string)$numberCode);
    }

    public function createValidDataWithString(): \Generator
    {
        yield [[0], '0'];
        yield [[7,7,7], '777'];
        yield [[0,1,2,3,4,5,6,7,8,9], '0123456789'];
    }
}
