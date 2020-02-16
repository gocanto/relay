<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Validator;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Rules\Constraint;
use Gocanto\Attributes\Rules\RulesCollection;
use Gocanto\Attributes\Validator\ValidatorManager;
use Mockery;
use PHPUnit\Framework\TestCase;

class ValidatorManagerTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstInvalidValidationsThatRequireData()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/was not provided/');

        $constraint = Mockery::mock(Constraint::class);
        $constraint->shouldReceive('getIdentifier')->once()->with()->andReturn('foo');

        $rules = new RulesCollection([
            'foo' => [$constraint],
        ]);

        $validator = new ValidatorManager($rules);

        $validator->validate([
            'bar' => null,
        ]);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstInvalidData()
    {
        $constraint = Mockery::mock(Constraint::class);
        $constraint->shouldReceive('getIdentifier')->once()->with()->andReturn('foo');
        $constraint->shouldReceive('assert')->once()->withArgs(function ($value, string $message) {
            $this->assertStringContainsString('does not abide by', $message);

            return $value === 'bar';
        });

        $rules = new RulesCollection([
            'foo' => [$constraint],
        ]);

        $validator = new ValidatorManager($rules);

        $validator->validate([
            'foo' => 'bar',
        ]);
    }
}
