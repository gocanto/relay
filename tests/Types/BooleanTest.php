<?php

declare(strict_types=1);

namespace Gocanto\Relay\Tests\Types;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Promoter;
use Gocanto\Relay\Tests\Stubs\Payload;
use Gocanto\Relay\Types\Boolean;
use PHPUnit\Framework\TestCase;

class BooleanTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itHoldsTrulyValues(): void
    {
        $data = $this->getPayload(Boolean::TRULY);
        $promoters = $this->getPromoters($data);

        $payload = new Payload($data, $promoters);

        foreach (array_keys($data) as $field) {
            $valid = $payload->get($field);

            $this->assertInstanceOf(Boolean::class, $valid);
            $this->assertTrue($valid->get());
            $this->assertTrue($valid->isTrue());
            $this->assertFalse($valid->isFalse());
        }
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itHoldsFalsyValues(): void
    {
        $data = $this->getPayload(Boolean::FALSY);
        $promoters = $this->getPromoters($data);

        $payload = new Payload($data, $promoters);

        foreach (array_keys($data) as $field) {
            $invalid = $payload->get($field);

            $this->assertInstanceOf(Boolean::class, $invalid);
            $this->assertFalse($invalid->get());
            $this->assertFalse($invalid->isTrue());
            $this->assertTrue($invalid->isFalse());
        }
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstInvalidValues(): void
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/invalid/');

        new Payload([
            'valid' => 'foo',
        ], [
            'valid' => Promoter::make(Boolean::class),
        ]);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itHoldsTrueAndFalseValuesProperly(): void
    {
        $payload = new Payload([
            'valid' => true,
            'invalid' => false,
        ], [
            'valid' => Promoter::make(Boolean::class),
            'invalid' => Promoter::make(Boolean::class),
        ]);

        /** @var Boolean $valid */
        $valid = $payload->get('valid');
        $this->assertInstanceOf(Boolean::class, $valid);
        $this->assertTrue($valid->get());
        $this->assertTrue($valid->isTrue());
        $this->assertFalse($valid->isFalse());

        /** @var Boolean $invalid */
        $invalid = $payload->get('invalid');
        $this->assertInstanceOf(Boolean::class, $invalid);
        $this->assertFalse($invalid->get());
        $this->assertFalse($invalid->isTrue());
        $this->assertTrue($invalid->isFalse());
    }

    private function getPayload(array $allowed): array
    {
        $data = [];
        $field = 1;

        foreach ($allowed as $item) {
            $data['field-' . $field++] = $item;
        }

        return $data;
    }

    /**
     * @param array $payload
     * @return array
     * @throws AttributesException
     */
    public function getPromoters(array $payload): array
    {
        $promoters = [];

        foreach ($payload as $field => $value) {
            $promoters[$field] = Promoter::make(Boolean::class);
        }

        return $promoters;
    }
}
