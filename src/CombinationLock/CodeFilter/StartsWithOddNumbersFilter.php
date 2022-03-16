<?php declare(strict_types=1);

namespace App\CombinationLock\CodeFilter;

use App\CombinationLock\NumberCode;

class StartsWithOddNumbersFilter implements FilterInterface
{
    /**
     * @param NumberCode[] $codes
     * @return NumberCode[]
     */
    public function filter(array $codes): array
    {
        $codes = array_filter($codes, function ($numberCode) {
            $startPosition = $numberCode->getCode()[0];
            return $startPosition & 1;
        });

        return $codes;
    }
}
