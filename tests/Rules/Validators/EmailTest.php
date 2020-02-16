<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Rules\Validators;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Rules\Constraint;
use Gocanto\Attributes\Rules\Validators\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    /**
     * @test
     */
    public function itHoldsValidData()
    {
        $constraint = new Email();

        $this->assertInstanceOf(Constraint::class, $constraint);
        $this->assertSame('email', $constraint->getIdentifier());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itProperlyValidateTheInputAndReturnGenericMessages()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/Expected a value to be a valid e-mail address/');

        $constraint = new Email();
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

        $constraint = new Email();
        $constraint->assert('foo', 'Message error stub');
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itAllowsValidValues()
    {
        $this->doesNotPerformAssertions();

        $constraint = new Email();
        $constraint->assert('gustavoocanto@gmail.com');
    }
}
