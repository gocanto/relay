<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Rules\Validators;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Rules\Constraint;
use Gocanto\Attributes\Rules\Validators\IntegerRule;
use PHPUnit\Framework\TestCase;

class IntegerTest extends TestCase
{
    /**
     * @test
     */
    public function itHoldsValidData()
    {
        $constraint = new IntegerRule();

        $this->assertInstanceOf(Constraint::class, $constraint);
        $this->assertSame('integer', $constraint->getIdentifier());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itProperlyValidateTheInputAndReturnGenericMessages()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/Expected an integer/');

        $constraint = new IntegerRule();
        $constraint->assert('foo');
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itProperlyValidateTheInputAndReturnCustomMessages()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/Message error stub/');

        $constraint = new IntegerRule();
        $constraint->assert('foo', 'Message error stub');
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itAllowsValidValues()
    {
        $this->doesNotPerformAssertions();

        $constraint = new IntegerRule();
        $constraint->assert(10);
    }
}
