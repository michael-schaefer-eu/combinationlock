<?php declare(strict_types=1);

namespace App\CombinationLock\CodeFilter;

interface FilterInterface
{
    public function filter(array $codes): array;
}
