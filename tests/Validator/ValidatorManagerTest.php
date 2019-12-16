<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Validator;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Rules\ConstraintsCollection;
use Gocanto\Attributes\Rules\RulesCollection;
use Gocanto\Attributes\Rules\Validators\Required;
use Gocanto\Attributes\Validator\ValidatorManager;
use Mockery;
use PHPUnit\Framework\TestCase;

class ValidatorManagerTest extends TestCase
{
    /** @var RulesCollection|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $rules;

    protected function setUp(): void
    {
        $this->rules = Mockery::mock(RulesCollection::class);
    }

    /**
     * @test
     */
    public function itChecksWhetherThereAreValidationRules()
    {
        $this->rules->shouldReceive('isEmpty')->once()->andReturn(true);

        $validator = new ValidatorManager($this->rules);

        $this->assertTrue($validator->isEmpty());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itSkipsValidationsIfRulesForGivenDataWereNotFound()
    {
        $this->rules->shouldReceive('getFor')->once()->with('foo')->andReturn(null);

        $validator = new ValidatorManager($this->rules);

        $validator->validate([
            'foo' => 'bar',
        ]);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itDoesNotRejectValidData()
    {
        $constraints = new ConstraintsCollection('foo', [
            new Required,
        ]);

        $this->rules->shouldReceive('getFor')->once()->with('foo')->andReturn($constraints);

        $validator = new ValidatorManager($this->rules);

        $validator->validate([
            'foo' => 'bar',
        ]);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itRejectsInvalidDatabasedOnTheGivenRules()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/required/');

        $constraints = new ConstraintsCollection('foo', [
            new Required,
        ]);

        $this->rules->shouldReceive('getFor')->once()->with('foo')->andReturn($constraints);

        $validator = new ValidatorManager($this->rules);

        $validator->validate([
            'foo' => '',
        ]);
    }
}
