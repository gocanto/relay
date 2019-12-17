<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Rules\Constraint;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Rules\Constraint;
use Gocanto\Attributes\Rules\Validators\Required;
use PHPUnit\Framework\TestCase;

class RequiredTest extends TestCase
{
    /**
     * @test
     */
    public function itHoldsValidData()
    {
        $constraint = new Required;

        $this->assertInstanceOf(Constraint::class, $constraint);
        $this->assertSame('required', $constraint->getIdentifier());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itProperlyValidateTheInputAndReturnGenericMessages()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/non-empty value/');

        $constraint = new Required;
        $constraint->assert('');
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itProperlyValidateTheInputAndReturnCustomMessages()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/foo bar/');

        $constraint = new Required;
        $constraint->assert('', 'foo bar');
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itAllowsValidValues()
    {
        $this->doesNotPerformAssertions();

        $constraint = new Required;
        $constraint->assert('foo', 'foo bar');
    }
}
