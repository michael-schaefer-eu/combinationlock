<?php declare(strict_types=1);

namespace App\CombinationLock\CodeFilter;

use App\CombinationLock\NumberCode;

interface FilterInterface
{
    /** @return NumberCode[] */
    public function filter(array $codes): array;
}
