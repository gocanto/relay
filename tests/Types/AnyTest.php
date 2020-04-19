<?php

declare(strict_types=1);

namespace Gocanto\Relay\Tests\Types;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Tests\Stubs\Payload;
use Gocanto\Relay\Type;
use Gocanto\Relay\Types\Any;
use JsonException;
use PHPUnit\Framework\TestCase;

class AnyTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException|JsonException
     */
    public function itRulesAreNotGivenTheReturnedTypeIsMixed(): void
    {
        $payload = new Payload($data = [
            'name' => 'Gustavo',
            'options' => [1, 2],
            'age' => 1,
            'empty' => [],
        ]);

        /** @var Any $name */
        $name = $payload->get('name');
        $this->assertInstanceOf(Type::class, $name);
        $this->assertInstanceOf(Any::class, $name);

        $this->assertSame('Gustavo', $name->get());
        $this->assertSame('Gustavo', $name->toString());

        /** @var Any $options */
        $options = $payload->get('options');
        $this->assertInstanceOf(Type::class, $name);
        $this->assertInstanceOf(Any::class, $name);

        $this->assertTrue($options->isArray());
        $this->assertSame(json_encode($data['options'], JSON_THROW_ON_ERROR), $options->toString());

        /** @var Any $age */
        $age = $payload->get('age');
        $this->assertInstanceOf(Type::class, $name);
        $this->assertInstanceOf(Any::class, $name);

        $this->assertFalse($age->isArray());
        $this->assertSame(1, $age->toInt());
        $this->assertSame(1.0, $age->toFloat());
        $this->assertSame('1', $age->toString());

        /** @var Any $empty */
        $empty = $payload->get('empty');
        $this->assertFalse($empty->isNotEmpty());
        $this->assertTrue($empty->isEmpty());
    }
}
