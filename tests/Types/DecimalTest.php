<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Types;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Promoter;
use Gocanto\Attributes\Tests\Stubs\Payload;
use Gocanto\Attributes\Types\Decimal;
use PHPUnit\Framework\TestCase;
use stdClass;

class DecimalTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itHoldsValidDecimals(): void
    {
        $payload = new Payload([
            'field-1' => 1.1,
            'field-2' => -1.1,
            'field-3' => 0,
            'field-4' => 9807.654,
        ], [
            'field-1' => Promoter::make(Decimal::class),
            'field-2' => Promoter::make(Decimal::class),
            'field-3' => Promoter::make(Decimal::class),
            'field-4' => Promoter::make(Decimal::class),
        ]);

        $fieldOne = $payload->get('field-1');
        $this->assertInstanceOf(Decimal::class, $fieldOne);
        $this->assertSame(1.1, $fieldOne->get());

        $fieldTwo = $payload->get('field-2');
        $this->assertInstanceOf(Decimal::class, $fieldTwo);
        $this->assertSame(-1.1, $fieldTwo->get());

        $fieldThree = $payload->get('field-3');
        $this->assertInstanceOf(Decimal::class, $fieldThree);
        $this->assertSame(0.0, $fieldThree->get());

        $fieldFour = $payload->get('field-4');
        $this->assertInstanceOf(Decimal::class, $fieldFour);
        $this->assertSame(9807.654, $fieldFour->get());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itProperlyParseValidStringContainingDecimals(): void
    {
        $payload = new Payload([
            'field-1' => '1.1',
            'field-2' => '-1.1',
            'field-3' => '0',
            'field-4' => '9807.654',
        ], [
            'field-1' => Promoter::make(Decimal::class),
            'field-2' => Promoter::make(Decimal::class),
            'field-3' => Promoter::make(Decimal::class),
            'field-4' => Promoter::make(Decimal::class),
        ]);

        $fieldOne = $payload->get('field-1');
        $this->assertInstanceOf(Decimal::class, $fieldOne);
        $this->assertSame(1.1, $fieldOne->get());

        $fieldTwo = $payload->get('field-2');
        $this->assertInstanceOf(Decimal::class, $fieldTwo);
        $this->assertSame(-1.1, $fieldTwo->get());

        $fieldThree = $payload->get('field-3');
        $this->assertInstanceOf(Decimal::class, $fieldThree);
        $this->assertSame(0.0, $fieldThree->get());

        $fieldFour = $payload->get('field-4');
        $this->assertInstanceOf(Decimal::class, $fieldFour);
        $this->assertSame(9807.654, $fieldFour->get());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstInvalidIntegers(): void
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/invalid/');

        new Payload([
            'field-1' => 'foo',
        ], [
            'field-1' => Promoter::make(Decimal::class),
        ]);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstNotAllowedValues(): void
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/invalid/');

        new Payload([
            'field-1' => new stdClass(),
        ], [
            'field-1' => Promoter::make(Decimal::class),
        ]);
    }
}
