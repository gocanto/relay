<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Rules;

class Rule
{
    /** @var string */
    private $field;
    /** @var Verifiers */
    private $verifiers;

    private function __construct()
    {
        $this->verifiers = new Verifiers;
    }

    /**
     * @param string $field
     * @return Rule
     */
    public static function make(string $field): Rule
    {
        $input = new static;
        $input->field = $field;

        return $input;
    }

    /**
     * @param array $verifiers
     * @return Rule
     */
    public function addVerifiers(array $verifiers): Rule
    {
        foreach ($verifiers as $verifier) {
            $this->verifiers->addMany($verifier);
        }

        return $this;
    }

    /**
     * @param Verifier $verifier
     * @return Rule
     */
    public function addVerifier(Verifier $verifier): Rule
    {
        $this->verifiers->add($verifier);

        return $this;
    }

    /**
     * @return Verifiers
     */
    public function getVerifiers(): Verifiers
    {
        return $this->verifiers;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }
}
