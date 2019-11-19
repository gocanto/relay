<?php

declare(strict_types=1);

namespace Gocanto\Attributes;

use Gocanto\Attributes\Rules\RulesCollection;

class Validator
{
    /** @var RulesCollection */
    private $rules;

    /**
     * @param RulesCollection $rules
     */
    public function __construct(RulesCollection $rules)
    {
        $this->rules = $rules;
    }

    public function inspects(array $fields): void
    {
        if ($this->rules->isEmpty()) {
            return;
        }

        foreach ($fields as $key => $field) {
            if ($this->rules->has($key)) {
                //perform validation here
            }
        }
    }
}
