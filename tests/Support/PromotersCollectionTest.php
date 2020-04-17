<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Support;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Promoter;
use Gocanto\Attributes\Support\PromotersCollection;
use Gocanto\Attributes\Types\Any;
use Gocanto\Attributes\Types\Text;
use PHPUnit\Framework\TestCase;

class PromotersCollectionTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itHoldsValidPromoters()
    {
        $promoter = Promoter::make(Text::class);
        $data = ['name' => $promoter];

        $collection = new PromotersCollection($data);

        $this->assertFalse($collection->isEmpty());
        $this->assertTrue($collection->has('name'));
        $this->assertFalse($collection->missing('name'));
        $this->assertSame($data, $collection->toArray());
        $this->assertSame($promoter, $collection->get('name'));
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstDuplicatedPromoters()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/already exists/');

        $collection = new PromotersCollection(['name' => Promoter::make(Text::class)]);
        $collection->add('name', Promoter::make(Text::class));
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itReturnsTheValidTypeForTheGivenInput()
    {
        $promoter = Promoter::make(Text::class);
        $data = ['name' => $promoter];

        $collection = new PromotersCollection($data);

        $type = $collection->getTypeFor('name', 'gustavo');

        $this->assertInstanceOf(Text::class, $type);
        $this->assertSame('gustavo', $type->get());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itReturnsTheMixedTypeForValuesWithoutPromoters()
    {
        $promoter = Promoter::make(Text::class);
        $data = ['name' => $promoter];

        $collection = new PromotersCollection($data);

        $type = $collection->getTypeFor('foo', 'gustavo');

        $this->assertInstanceOf(Any::class, $type);
        $this->assertSame('gustavo', $type->get());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function throwExceptionsForInvalidExpectedTypedValues()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/invalid/');

        $promoter = Promoter::make(Text::class);
        $data = ['name' => $promoter];

        $collection = new PromotersCollection($data);

        $collection->getTypeFor('name', 1);
    }
}
