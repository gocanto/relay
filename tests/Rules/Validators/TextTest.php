<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Rules\Validators;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Rules\Constraint;
use Gocanto\Attributes\Rules\Validators\Same;
use Gocanto\Attributes\Rules\Validators\Text;
use PHPUnit\Framework\TestCase;

class TextTest extends TestCase
{
    /**
     * @test
     */
    public function itHoldsValidData()
    {
        $constraint = new Text();

        $this->assertInstanceOf(Constraint::class, $constraint);
        $this->assertSame('text', $constraint->getIdentifier());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itProperlyValidateTheInputAndReturnGenericMessages()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/Expected a string. Got/');

        $constraint = new Text();
        $constraint->assert(1);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itProperlyValidateTheInputAndReturnCustomMessages()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/Message error stub/');

        $constraint = new Text();
        $constraint->assert(1, 'Message error stub');
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itAllowsValidValues()
    {
        $this->doesNotPerformAssertions();

        $constraint = new Text();
        $constraint->assert('gus');
    }
}
