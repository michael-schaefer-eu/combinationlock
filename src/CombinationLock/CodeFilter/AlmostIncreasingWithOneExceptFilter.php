<?php declare(strict_types=1);

namespace App\CombinationLock\CodeFilter;

use App\CombinationLock\NumberCode;

class AlmostIncreasingWithOneExceptFilter implements FilterInterface
{
    /**
     * @param NumberCode[] $codes
     * @return NumberCode[]
     */
    public function filter(array $codes): array
    {
        $codes = array_filter($codes, function ($numberCode) {
            $code = $numberCode->getCode();
            $stepDown = 0;

            for ($i = 0; $i < $numberCode->getCodeLength() -1; $i++) {
                $tx = $code[$i];
                $ty = $code[$i+1];

                // if the following number (ty) is smaller than the previous number (tx) then it's a stepdown.
                if ($ty < $tx) {
                    $stepDown++;
                }

                // Only one stepdown is allowed, so throw filter out that NumberCode if it has a second one.
                if ($stepDown > 1) {
                    return false;
                }
            }

            return true;
        });

        return $codes;
    }
}
