<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Rules;

class Inputs
{
    /** @var Rule[] */
    private $inputs;

    /**
     * @param array $inputs
     */
    public function __construct(array $inputs)
    {
        $this->addMany($inputs);
    }

    /**
     * @param array $inputs
     */
    public function addMany(array $inputs): void
    {
        foreach ($inputs as $input) {
            $this->add($input);
        }
    }

    /**
     * @param Rule $input
     */
    public function add(Rule $input): void
    {
        $this->inputs[] = $input;
    }
}
