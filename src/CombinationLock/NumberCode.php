<?php declare(strict_types=1);

namespace App\CombinationLock;

/**
 * This is a ValueObject, it can be created but not changed.
 */
class NumberCode
{
    private array $code;

    public function __construct(array $code)
    {
        $this->setCode($code);
    }

    private function setCode(array $code): void
    {
        if (count($code) < 1) {
            throw new \InvalidArgumentException('Empty code. The code must contain only numbers between 0 and 9.');
        }

        foreach ($code as $cipher) {
            if (!is_int($cipher) || $cipher < 0 || $cipher > 9) {
                throw new \InvalidArgumentException('Illegal character! The code must contain only numbers between 0 and 9.');
            }
        }

        $this->code = $code;
    }

    public function getCode(): array
    {
        return $this->code;
    }

    public function __toString(): string
    {
        return array_reduce($this->getCode(), function($ax, $dx) { return $ax . "{$dx}"; });
    }
}
