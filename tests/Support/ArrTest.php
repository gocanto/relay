<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Support;

use Gocanto\Attributes\Support\Arr;
use PHPUnit\Framework\TestCase;

class ArrTest extends TestCase
{
    /** @var array */
    private $fields;

    protected function setUp(): void
    {
        $this->fields = [
            'name' => 'Gustavo',
            'last_name' => 'Ocanto',
            'address' => [
                'country' => 'Venezuela',
                'foo' => [
                    'bar' => 'biz value',
                ],
            ],
        ];
    }

    /**
     * @test
     */
    public function itChecksForExistingKeys()
    {
        $this->assertTrue(Arr::exists($this->fields, 'name'));
        $this->assertFalse(Arr::exists($this->fields, 'address.country'));
    }

    /**
     * @test
     */
    public function itAllowsPullingValuesUsingDotNotation()
    {
        $this->assertNull(Arr::get($this->fields, 'bar'));

        $this->assertSame('Gustavo', Arr::get($this->fields, 'name'));
        $this->assertSame('Venezuela', Arr::get($this->fields, 'address.country'));
        $this->assertSame('biz value', Arr::get($this->fields, 'address.foo.bar'));

        $this->assertNull(Arr::get($this->fields, 'foo'));
        $this->assertNull(Arr::get($this->fields, 'address.bar'));
    }

    /**
     * @test
     */
    public function itFlattensAnArrayUsingDotNotation()
    {
        $array = Arr::dot($this->fields);

        $this->assertSame('Gustavo', $array['name']);
        $this->assertSame('Ocanto', $array['last_name']);
        $this->assertSame('Venezuela', $array['address.country']);
        $this->assertSame('biz value', $array['address.foo.bar']);
    }
}
