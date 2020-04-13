<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Types;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Promoter;
use Gocanto\Attributes\Tests\Stubs\Payload;
use Gocanto\Attributes\Type;
use Gocanto\Attributes\Types\Uuid;
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

        $payload = new Payload([
            'uuid' => 'foo',
        ], [
            'uuid' => Promoter::make(Uuid::class),
        ]);

        $payload->get('uuid');
    }
}
