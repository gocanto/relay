<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Stubs;

use Gocanto\Attributes\Attributes;
use Gocanto\Attributes\Rules\Rule;
use Gocanto\Attributes\Rules\RuleException;
use Gocanto\Attributes\Rules\RulesCollection;
use Gocanto\Attributes\Runners\Required;

class DummyAttributes extends Attributes
{
    /**
     * @inheritDoc
     * @throws RuleException
     */
    public function getValidationRules(): RulesCollection
    {
        //@todo
        //1 - require rules and not the collection.
        //2 - we do not need the runners. Try to make it work with the rules or improve the set up.

        $rule = Rule::make('name');
        $rule->addRunner(new Required);

        return new RulesCollection([
            $rule
        ]);
    }
}
