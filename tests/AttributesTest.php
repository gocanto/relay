<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Tests\Stubs\Customer;
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
        ]);

        $this->assertSame('gustavo', $customer->get('first_name'));
        $this->assertSame('ocanto', $customer->get('last_name'));
        $this->assertSame('foo', $customer->get('require_value'));
        $this->assertSame($data, $customer->toArray());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstEmptyData()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/The given attributes data cannot be empty/');

        new Customer([]);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstInvalidRequiredValues()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/require_value/');
        $this->expectExceptionMessageMatches('/require/');

        new Customer([
            'first_name' => 'gustavo',
            'last_name' => 'ocanto',
            'require_value' => '',
        ]);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function emptyStringsAreNotAllowedForTheGivenCustomerLastName()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/last_name/');
        $this->expectExceptionMessageMatches('/string-not-empty/');

        new Customer([
            'first_name' => 'gustavo',
            'last_name' => '',
        ]);
    }
}
