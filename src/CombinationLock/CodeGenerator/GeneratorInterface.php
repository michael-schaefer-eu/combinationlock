<?php declare(strict_types=1);

namespace App\CombinationLock\CodeGenerator;

use App\CombinationLock\NumberCode;

interface GeneratorInterface
{
    /** @return NumberCode[] */
    public function generate(int $length): array;
}
