<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Types;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Tests\Stubs\Payload;
use Gocanto\Attributes\Type;
use Gocanto\Attributes\Types\Mixed;
use JsonException;
use PHPUnit\Framework\TestCase;

class MixedTest extends TestCase
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

        /** @var Mixed $name */
        $name = $payload->get('name');
        $this->assertInstanceOf(Type::class, $name);
        $this->assertInstanceOf(Mixed::class, $name);

        $this->assertSame('Gustavo', $name->get());
        $this->assertSame('Gustavo', $name->toString());

        /** @var Mixed $options */
        $options = $payload->get('options');
        $this->assertInstanceOf(Type::class, $name);
        $this->assertInstanceOf(Mixed::class, $name);

        $this->assertTrue($options->isArray());
        $this->assertSame(json_encode($data['options'], JSON_THROW_ON_ERROR), $options->toString());

        /** @var Mixed $age */
        $age = $payload->get('age');
        $this->assertInstanceOf(Type::class, $name);
        $this->assertInstanceOf(Mixed::class, $name);

        $this->assertFalse($age->isArray());
        $this->assertSame(1, $age->toInt());
        $this->assertSame(1.0, $age->toFloat());
        $this->assertSame('1', $age->toString());

        /** @var Mixed $empty */
        $empty = $payload->get('empty');
        $this->assertFalse($empty->isNotEmpty());
        $this->assertTrue($empty->isEmpty());
    }
}
