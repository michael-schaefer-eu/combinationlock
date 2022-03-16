<?php declare(strict_types=1);

namespace Unit\CombinationLock\CodeFilter;

use App\CombinationLock\CodeFilter\NotContainsNumberFilter;
use App\CombinationLock\NumberCode;
use PHPUnit\Framework\TestCase;

final class NotContainsNumberFilterTest extends TestCase
{
    public function testFilterRemovesNone(): void
    {
        $filter = new NotContainsNumberFilter(4);
        $codes = [
            new NumberCode([0,0,1]),
            new NumberCode([0,1,3]),
            new NumberCode([3,5,1]),
            new NumberCode([7,5,9]),
            new NumberCode([7,7,7]),
        ];

        $this->assertCount(5, $filter->filter($codes));
    }

    public function testFilterRemovesAll(): void
    {
        $filter = new NotContainsNumberFilter(4);
        $codes = [
            new NumberCode([0,0,4]),
            new NumberCode([0,1,4]),
            new NumberCode([3,4,1]),
            new NumberCode([4,5,6]),
            new NumberCode([4,4,4]),
        ];

        $this->assertCount(0, $filter->filter($codes));
    }
}
