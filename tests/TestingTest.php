<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests;

use Gocanto\Attributes\AttributesException;
use PHPUnit\Framework\TestCase;

class TestingTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function testingThisCode()
    {
        $customer = new Customer([
            'first_name' => 'gustavo',
            'last_name' => 'ocanto',
        ]);

        $this->assertSame('gustavo', $customer->get('first_name'));
        $this->assertSame('ocanto', $customer->get('last_name'));
    }
}
