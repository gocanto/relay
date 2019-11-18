<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Rules;

use Gocanto\Attributes\AttributeException;

class Validator
{
    /** @var Rule[] */
    private $rules;

    /**
     * @param array $rules
     */
    public function __construct(array $rules = [])
    {
        $this->addManyRules($rules);
    }

    /**
     * @param array $rules
     */
    public function addManyRules(array $rules): void
    {
        foreach ($rules as $rule) {
            $this->addRule($rule);
        }
    }

    /**
     * @param Rule $rule
     */
    public function addRule(Rule $rule): void
    {
        $this->rules[$rule->getField()] = $rule;
    }

    /**
     * @param array $data
     * @throws AttributeException
     */
    public function validate(array $data): void
    {
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->rules)) {
                $this->verify($key, $value);
            }
        }
    }

    /**
     * @param string $target
     * @param $value
     * @throws AttributeException
     */
    private function verify(string $target, $value): void
    {
        $rule = $this->rules[$target];

        $verified = $rule->getVerifiers()->verify($value);

        if ($verified === false) {
            throw new AttributeException("The given attribute [{$target}] is invalid.");
        }
    }
}
