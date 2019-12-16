<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Support;

use ArrayAccess;
use Gocanto\Attributes\Support\Arr;
use Mockery;
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
                ]
            ],
        ];
    }

    /**
     * @test
     */
    public function itChecksWhetherTheGivenValueIsArrayAccessible()
    {
        $this->assertTrue(Arr::accessible($this->fields));
        $this->assertTrue(Arr::accessible(Mockery::mock(ArrayAccess::class)));
    }

    /**
     * @test
     */
    public function itChecksForExistingKeys()
    {
        $this->assertTrue(Arr::exists($this->fields, 'name'));
        $this->assertFalse(Arr::exists($this->fields, 'address.country'));

        $array = Mockery::mock(ArrayAccess::class);
        $array->shouldReceive('offsetExists')->once()->with('name')->andReturn(true);
        $this->assertTrue(Arr::exists($array, 'name'));
    }

    /**
     * @test
     */
    public function itAllowsPullingValuesUsingDotNotation()
    {
        $this->assertNull(Arr::get('__INVALID___', 'name'));

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
