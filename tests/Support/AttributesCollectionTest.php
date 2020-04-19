<?php

declare(strict_types=1);

namespace Gocanto\Relay\Tests\Support;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Support\AttributesCollection;
use Gocanto\Relay\Type;
use Mockery;
use PHPUnit\Framework\TestCase;

class AttributesCollectionTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itHoldsValidData()
    {
        $attr = Mockery::mock(Type::class);
        $data = ['foo' => $attr];

        $collection = new AttributesCollection($data);

        $this->assertSame($data, $collection->toArray());
        $this->assertSame($attr, $collection->get('foo'));
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itReturnEmptyIfNotAttributesAreGiven()
    {
        $collection = new AttributesCollection([]);

        $this->assertSame([], $collection->toArray());
        $this->assertNull($collection->get('foo'));
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstDuplicatedAttributes()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/already exists/');

        $attr = Mockery::mock(Type::class);
        $data = ['foo' => $attr];

        $collection = new AttributesCollection($data);
        $collection->add('foo', $attr);
    }
}
