<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Types;

use Carbon\CarbonImmutable;
use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Promoter;
use Gocanto\Attributes\Tests\Stubs\Payload;
use Gocanto\Attributes\Type;
use Gocanto\Attributes\Types\Date;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    protected function setUp(): void
    {
        CarbonImmutable::setTestNow(null);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itReturnsValidDates(): void
    {
        $now = CarbonImmutable::now();

        $payload = new Payload([
            'date' => $now->toDateTimeString(),
        ], [
            'date' => Promoter::make(Date::class),
        ]);

        /** @var Date $date */
        $date = $payload->get('date');
        $this->assertInstanceOf(Date::class, $date);
        $this->assertInstanceOf(Type::class, $date);
        $this->assertSame($now->toDateTimeString(), $date->toString());
        $this->assertSame($now->toDateTimeString(), $date->getCarbon()->toDateTimeString());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itRejectsInvalidDates(): void
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/invalid/');

        $payload = new Payload([
            'date' => 1,
        ], [
            'date' => Promoter::make(Date::class),
        ]);

        $payload->get('date');
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itRejectsInvalidDateFormat(): void
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/invalid/');

        $payload = new Payload([
            'date' => 'foo',
        ], [
            'date' => Promoter::make(Date::class),
        ]);

        $payload->get('date');
    }
}
