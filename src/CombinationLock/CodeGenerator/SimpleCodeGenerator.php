<?php declare(strict_types=1);

namespace App\CombinationLock\CodeGenerator;

use App\CombinationLock\NumberCode;

class SimpleCodeGenerator implements GeneratorInterface
{
    /**
     * @param int $length
     * @return NumberCode[]
     */
    public function generate(int $length): array
    {
        $codes = [];

        $format = '%\'.0' . $length . 'd';
        $number = 0;

        while (ceil(log10($number|1)) <= $length) {
            $code = array_map('intval', str_split(sprintf($format, $number)));
            $codes[] = new NumberCode($code);
            $number++;
        }

        return $codes;
    }
}
