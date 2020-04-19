<?php

declare(strict_types=1);

namespace Gocanto\Relay\Tests\Types;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Promoter;
use Gocanto\Relay\Tests\Stubs\Payload;
use Gocanto\Relay\Type;
use Gocanto\Relay\Types\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itReturnsValidUuidValues(): void
    {
        $payload = new Payload([
            'uuid' => 'e02582b5-048d-42fa-aa09-1737d813927f',
        ], [
            'uuid' => Promoter::make(Uuid::class),
        ]);

        $uuid = $payload->get('uuid');
        $this->assertInstanceOf(Uuid::class, $uuid);
        $this->assertInstanceOf(Type::class, $uuid);
        $this->assertSame('e02582b5-048d-42fa-aa09-1737d813927f', $uuid->get());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itRejectsInvalidUuid(): void
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/invalid/');

        new Payload([
            'uuid' => 'foo',
        ], [
            'uuid' => Promoter::make(Uuid::class),
        ]);
    }
}
