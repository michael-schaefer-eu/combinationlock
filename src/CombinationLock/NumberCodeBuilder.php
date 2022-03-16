<?php declare(strict_types=1);

namespace App\CombinationLock;

use App\CombinationLock\CodeFilter\FilterInterface;
use App\CombinationLock\CodeGenerator\GeneratorInterface;

class NumberCodeBuilder
{
    private GeneratorInterface $codeGenerator;

    /** @var FilterInterface[] */
    private array $codeFilters = [];

    public function __construct(GeneratorInterface $codeGenerator, array $codeFilters = [])
    {
        $this->setCodeGenerator($codeGenerator);
        $this->setCodeFilters($codeFilters);
    }

    protected function setCodeGenerator(GeneratorInterface $codeGenerator): void
    {
        $this->codeGenerator = $codeGenerator;
    }

    protected function getCodeGenerator(): GeneratorInterface
    {
        return $this->codeGenerator;
    }

    protected function setCodeFilters(array $codeFilters): void
    {
        foreach ($codeFilters as $filter) {
            if (!$filter instanceof FilterInterface) {
                throw new \InvalidArgumentException('Code filters must implement the FilterInterface (' . FilterInterface::class . ').');
            }
        }

        $this->codeFilters = $codeFilters;
    }

    /**
     * @return FilterInterface[]
     */
    protected function getCodeFilters(): array
    {
        return $this->codeFilters;
    }

    public function buildCodes(int $codeLength): array
    {
        $codes = $this->codeGenerator->generate($codeLength);

        foreach ($this->getCodeFilters() as $filter) {
            $codes = $filter->filter($codes);
        }

        return $codes;
    }
}
