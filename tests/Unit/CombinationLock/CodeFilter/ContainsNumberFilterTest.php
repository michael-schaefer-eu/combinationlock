<?php declare(strict_types=1);

namespace Unit\CombinationLock\CodeFilter;

use App\CombinationLock\CodeFilter\ContainsNumberFilter;
use App\CombinationLock\NumberCode;
use PHPUnit\Framework\TestCase;

final class ContainsNumberFilterTest extends TestCase
{
    public function testFilterRemovesNone(): void
    {
        $filter = new ContainsNumberFilter(5);
        $codes = [
            new NumberCode([0,0,5]),
            new NumberCode([0,1,5]),
            new NumberCode([3,5,1]),
            new NumberCode([7,5,9]),
            new NumberCode([7,7,5]),
        ];

        $this->assertCount(5, $filter->filter($codes));
    }

    public function testFilterRemovesAll(): void
    {
        $filter = new ContainsNumberFilter(5);
        $codes = [
            new NumberCode([0,0,4]),
            new NumberCode([0,1,4]),
            new NumberCode([3,4,1]),
            new NumberCode([4,6,7]),
            new NumberCode([7,7,7]),
        ];

        $this->assertCount(0, $filter->filter($codes));
    }
}
