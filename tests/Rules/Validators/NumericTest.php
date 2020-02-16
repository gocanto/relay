<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Rules\Validators;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Rules\Constraint;
use Gocanto\Attributes\Rules\Validators\Numeric;
use PHPUnit\Framework\TestCase;

class NumericTest extends TestCase
{
    /**
     * @test
     */
    public function itHoldsValidData()
    {
        $constraint = new Numeric();

        $this->assertInstanceOf(Constraint::class, $constraint);
        $this->assertSame('numeric', $constraint->getIdentifier());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itProperlyValidateTheInputAndReturnGenericMessages()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/Expected a numeric. Got/');

        $constraint = new Numeric();
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

        $constraint = new Numeric();
        $constraint->assert('foo', 'Message error stub');
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itAllowsValidValues()
    {
        $this->doesNotPerformAssertions();

        $constraint = new Numeric();
        $constraint->assert(1);
    }
}
