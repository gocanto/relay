<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests;

use Gocanto\Attributes\Attributes;
use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Rules\Validators\Boolean;
use Gocanto\Attributes\Rules\Validators\Email;
use Gocanto\Attributes\Rules\Validators\Required;
use Gocanto\Attributes\Rules\Validators\StringNotEmpty;
use Gocanto\Attributes\Tests\Stubs\Customer;
use Gocanto\Attributes\Validator\Validator;
use Mockery;
use PHPUnit\Framework\TestCase;

class AttributesTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itAllowsValidData()
    {
        $customer = new Customer($data = [
            'first_name' => 'gustavo',
            'last_name' => 'ocanto',
            'require_value' => 'foo',
            'is_admin' => true,
            'email' => 'gustavoocanto@gmail.com',
        ]);

        $this->assertSame('gustavo', $customer->get('first_name'));
        $this->assertSame('ocanto', $customer->get('last_name'));
        $this->assertSame('foo', $customer->get('require_value'));
        $this->assertSame('gustavoocanto@gmail.com', $customer->get('email'));
        $this->assertTrue($customer->get('is_admin'));
        $this->assertSame($data, $customer->toArray());
    }

    /**
     * @test
     */
    public function itGuardsAgainstEmptyData()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/The given attributes data cannot be empty/');

        new class([]) extends Attributes {
        };
    }

    /**
     * @test
     */
    public function itGuardsAgainstInvalidRequiredValues()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/require_value/');
        $this->expectExceptionMessageMatches('/require/');

        new class(['name' => '']) extends Attributes {
            protected function getValidationRules(): array
            {
                return [
                    'name' => [new Required()],
                ];
            }
        };
    }

    /**
     * @test
     */
    public function emptyStringsAreNotAllowedForTheGivenCustomerLastName()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/last_name/');
        $this->expectExceptionMessageMatches('/string-not-empty/');

        new class(['name' => '']) extends Attributes {
            protected function getValidationRules(): array
            {
                return [
                    'name' => [new StringNotEmpty()],
                ];
            }
        };
    }

    /**
     * @test
     */
    public function itGuardsAgainstInvalidBooleanValues()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/is_admin/');
        $this->expectExceptionMessageMatches('/boolean/');

        new class(['is_admin' => 'yes']) extends Attributes {
            protected function getValidationRules(): array
            {
                return [
                    'is_admin' => [new Boolean()],
                ];
            }
        };
    }

    /**
     * @test
     */
    public function itGuardsAgainstInvalidEmails()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/email/');
        $this->expectExceptionMessageMatches('/email/');

        new class(['email' => 'foo']) extends Attributes {
            protected function getValidationRules(): array
            {
                return [
                    'email' => [new Email()],
                ];
            }
        };
    }

    /**
     * @test
     */
    public function itReturnsTheSameDataIfNotValidationsRulesWereFound()
    {
        $attributes = new class(['email' => 'foo']) extends Attributes {
        };

        $data = $attributes->toArray();

        $this->assertEquals('foo', $data['email']);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itAllowsSwappingItsValidator()
    {
        $attributes = new class(['email' => 'foo']) extends Attributes {
        };

        $this->assertInstanceOf(Validator::class, $attributes->getValidator());

        $validator = Mockery::mock(Validator::class);

        $attrs = $attributes->withValidator($validator);

        $this->assertSame($validator, $attrs->getValidator());
    }
}
