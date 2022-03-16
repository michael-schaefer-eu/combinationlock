<?php declare(strict_types=1);

namespace Unit\CombinationLock\CodeFilter;

use App\CombinationLock\CodeFilter\StartsWithOddNumbersFilter;
use App\CombinationLock\NumberCode;
use PHPUnit\Framework\TestCase;

final class StartsWithOddNumbersFilterTest extends TestCase
{
    public function testFilterRemovesNone(): void
    {
        $filter = new StartsWithOddNumbersFilter();
        $codes = [
            new NumberCode([1,0,0]),
            new NumberCode([3,1,5]),
            new NumberCode([5,5,1]),
            new NumberCode([7,5,9]),
            new NumberCode([9,7,5]),
        ];

        $this->assertCount(5, $filter->filter($codes));
    }

    public function testFilterRemovesAll(): void
    {
        $filter = new StartsWithOddNumbersFilter();
        $codes = [
            new NumberCode([0,0,4]),
            new NumberCode([2,1,4]),
            new NumberCode([4,4,1]),
            new NumberCode([6,6,7]),
            new NumberCode([8,7,7]),
        ];

        $this->assertCount(0, $filter->filter($codes));
    }
}
