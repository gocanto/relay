<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Stubs;

class DummyAttributes
{
    /**
     * @return RulesCollection
     * @throws RuleException
     */
    public function getValidationRules(): RulesCollection
    {
        return new RulesCollection([
            Rule::make('foo')->addRunner(new Required),
        ]);
    }
}
