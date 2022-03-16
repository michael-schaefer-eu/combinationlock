<?php declare(strict_types=1);

namespace Unit\CombinationLock\CodeFilter;

use App\CombinationLock\CodeFilter\AlmostIncreasingWithOneExceptFilter;
use App\CombinationLock\NumberCode;
use PHPUnit\Framework\TestCase;

final class AlmostIncreasingWithOneExceptFilterTest extends TestCase
{
    public function testFilterRemovesNone(): void
    {
        $filter = new AlmostIncreasingWithOneExceptFilter();
        $codes = [
            new NumberCode([1,1,1,1,1]),
            new NumberCode([1,2,3,4,5]),
            new NumberCode([3,4,5,3,7]),
            new NumberCode([3,4,5,1,9]),
            new NumberCode([9,1,9,9,9]),
            new NumberCode([9,1,2,3,4]),
            new NumberCode([1,1,5,6,0]),
            new NumberCode([3,5,6,1,6]),
            new NumberCode([1,5,6,3,3]),
            new NumberCode([3,5,6,1,3]),
            new NumberCode([9,1,5,5,6]),
        ];

        $this->assertCount(11, $filter->filter($codes));
    }

    public function testFilterRemovesAll(): void
    {
        $filter = new AlmostIncreasingWithOneExceptFilter();
        $codes = [
            new NumberCode([5,4,3,2,1]),
            new NumberCode([9,9,7,5,5]),
            new NumberCode([7,6,7,6,7]),
            new NumberCode([7,8,9,8,7]),
            new NumberCode([1,1,9,8,7]),
        ];

        $this->assertCount(0, $filter->filter($codes));
    }
}
