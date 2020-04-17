<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Types;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Promoter;
use Gocanto\Attributes\Tests\Stubs\Payload;
use Gocanto\Attributes\Types\Integer;
use PHPUnit\Framework\TestCase;
use stdClass;

class IntegerTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itHoldsValidIntegers(): void
    {
        $payload = new Payload([
            'field-1' => 1,
            'field-2' => -1,
            'field-3' => 0,
            'field-4' => 9807654,
        ], [
            'field-1' => Promoter::make(Integer::class),
            'field-2' => Promoter::make(Integer::class),
            'field-3' => Promoter::make(Integer::class),
            'field-4' => Promoter::make(Integer::class),
        ]);

        $fieldOne = $payload->get('field-1');
        $this->assertInstanceOf(Integer::class, $fieldOne);
        $this->assertSame(1, $fieldOne->get());

        $fieldTwo = $payload->get('field-2');
        $this->assertInstanceOf(Integer::class, $fieldTwo);
        $this->assertSame(-1, $fieldTwo->get());

        $fieldThree = $payload->get('field-3');
        $this->assertInstanceOf(Integer::class, $fieldThree);
        $this->assertSame(0, $fieldThree->get());

        $fieldFour = $payload->get('field-4');
        $this->assertInstanceOf(Integer::class, $fieldFour);
        $this->assertSame(9807654, $fieldFour->get());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itProperlyParseValidStringContainingIntegers(): void
    {
        $payload = new Payload([
            'field-1' => '1',
            'field-2' => '-1',
            'field-3' => '0',
            'field-4' => '9807654',
        ], [
            'field-1' => Promoter::make(Integer::class),
            'field-2' => Promoter::make(Integer::class),
            'field-3' => Promoter::make(Integer::class),
            'field-4' => Promoter::make(Integer::class),
        ]);

        $fieldOne = $payload->get('field-1');
        $this->assertInstanceOf(Integer::class, $fieldOne);
        $this->assertSame(1, $fieldOne->get());

        $fieldTwo = $payload->get('field-2');
        $this->assertInstanceOf(Integer::class, $fieldTwo);
        $this->assertSame(-1, $fieldTwo->get());

        $fieldThree = $payload->get('field-3');
        $this->assertInstanceOf(Integer::class, $fieldThree);
        $this->assertSame(0, $fieldThree->get());

        $fieldFour = $payload->get('field-4');
        $this->assertInstanceOf(Integer::class, $fieldFour);
        $this->assertSame(9807654, $fieldFour->get());
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
            'field-1' => Promoter::make(Integer::class),
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
            'field-1' => Promoter::make(Integer::class),
        ]);
    }
}
