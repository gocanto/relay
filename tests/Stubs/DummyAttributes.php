<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Stubs;

use Gocanto\Attributes\Attributes;
use Gocanto\Attributes\Rules\Rule;
use Gocanto\Attributes\Rules\RuleException;
use Gocanto\Attributes\Rules\RulesCollection;
use Gocanto\Attributes\Rules\Runners\Required;

class DummyAttributes extends Attributes
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
