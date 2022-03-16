<?php declare(strict_types=1);

namespace Unit\CombinationLock;

use App\CombinationLock\CodeFilter\FilterInterface;
use App\CombinationLock\CodeGenerator\GeneratorInterface;
use App\CombinationLock\NumberCode;
use App\CombinationLock\NumberCodeBuilder;
use PHPUnit\Framework\TestCase;

final class NumberCodeBuilderTest extends TestCase
{
    public function testNumberCodeBuilderWithoutFilters(): void
    {
        $codes = [new NumberCode([1,2,3])];

        $generator = $this->createMock(GeneratorInterface::class);
        $generator->expects($this->once())
            ->method('generate')
            ->with($this->equalTo(5))
            ->willReturn($codes);

        $builder = new NumberCodeBuilder($generator);
        $result = $builder->buildCodes(5);

        $this->assertSame($codes, $result);
    }

    public function testNumberCodeBuilderWithFilters(): void
    {
        $codes = [new NumberCode([1,2,3]), new NumberCode([4,5,6])];

        $generator = $this->createMock(GeneratorInterface::class);
        $generator->expects($this->once())
            ->method('generate')
            ->with($this->equalTo(5))
            ->willReturn($codes);

        $filterNothing = $this->createMock(FilterInterface::class);
        $filterNothing->expects($this->once())
            ->method('filter')
            ->with($this->equalTo($codes))
            ->willReturn($codes);

        $filterFirst = $this->createMock(FilterInterface::class);
        $filterFirst->expects($this->once())
            ->method('filter')
            ->with($this->equalTo($codes))
            ->willReturn([$codes[0]]);

        $builder = new NumberCodeBuilder($generator, [$filterNothing, $filterFirst]);
        $result = $builder->buildCodes(5);

        $this->assertSame([$codes[0]], $result);
    }

    public function testNumberCodeBuilderWithWrongFilterType(): void
    {
        $generator = $this->createMock(GeneratorInterface::class);
        $filterWrong = $this->createMock(\stdClass::class);

        $this->expectException(\InvalidArgumentException::class);
        $builder = new NumberCodeBuilder($generator, [$filterWrong]);
    }
}
