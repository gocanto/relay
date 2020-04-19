<?php

declare(strict_types=1);

namespace Gocanto\Relay\Tests\Types;

use Carbon\CarbonImmutable;
use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Promoter;
use Gocanto\Relay\Tests\Stubs\Payload;
use Gocanto\Relay\Type;
use Gocanto\Relay\Types\Date;
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
        $this->assertSame($now->toDateTimeString(), (string) $date->get());
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

        new Payload([
            'date' => 1,
        ], [
            'date' => Promoter::make(Date::class),
        ]);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itRejectsInvalidDateFormat(): void
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/invalid/');

        new Payload([
            'date' => 'foo',
        ], [
            'date' => Promoter::make(Date::class),
        ]);
    }
}
