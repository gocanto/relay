<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Rules\Validators;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Rules\Constraint;
use Gocanto\Attributes\Rules\Validators\Same;
use PHPUnit\Framework\TestCase;

class SameTest extends TestCase
{
    /**
     * @test
     */
    public function itHoldsValidData()
    {
        $constraint = new Same(12);

        $this->assertInstanceOf(Constraint::class, $constraint);
        $this->assertSame('same', $constraint->getIdentifier());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itProperlyValidateTheInputAndReturnGenericMessages()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/Expected a value identical to 12. Got/');

        $constraint = new Same(12);
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

        $constraint = new Same(12);
        $constraint->assert('foo', 'Message error stub');
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itAllowsValidValues()
    {
        $this->doesNotPerformAssertions();

        $constraint = new Same(12);
        $constraint->assert(12);
    }
}
