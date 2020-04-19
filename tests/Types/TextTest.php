<?php

declare(strict_types=1);

namespace Gocanto\Relay\Tests\Types;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Promoter;
use Gocanto\Relay\Tests\Stubs\Payload;
use Gocanto\Relay\Type;
use Gocanto\Relay\Types\Text;
use PHPUnit\Framework\TestCase;

class TextTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itReturnsValidTexts(): void
    {
        $payload = new Payload([
            'name' => 'Gustavo',
        ], [
            'name' => Promoter::make(Text::class),
        ]);

        $name = $payload->get('name');
        $this->assertInstanceOf(Type::class, $name);
        $this->assertInstanceOf(Text::class, $name);
        $this->assertSame('Gustavo', $name->get());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itRejectsInvalidTexts(): void
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/invalid/');

        new Payload([
            'name' => 1,
        ], [
            'name' => Promoter::make(Text::class),
        ]);
    }
}
