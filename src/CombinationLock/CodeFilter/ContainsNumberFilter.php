<?php declare(strict_types=1);

namespace App\CombinationLock\CodeFilter;

use App\CombinationLock\NumberCode;

class ContainsNumberFilter implements FilterInterface
{
    private int $number;

    public function __construct(int $number)
    {
        $this->number = $number;
    }

    /**
     * @param NumberCode[] $codes
     * @return NumberCode[]
     */
    public function filter(array $codes): array
    {
        $codes = array_filter($codes, function ($numberCode) {
            return in_array($this->number, $numberCode->getCode());
        });

        return $codes;
    }
}
