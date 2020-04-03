<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Types;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Promoter;
use Gocanto\Attributes\Tests\Stubs\Payload;
use Gocanto\Attributes\Types\Boolean;
use PHPUnit\Framework\TestCase;

class BooleanTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itHoldsTrulyValues()
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
    public function itHoldsFalsyValues()
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
    public function itGuardsAgainstInvalidValues()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/invalid/');

        $payload = new Payload([
            'valid' => 'foo',
        ], [
            'valid' => Promoter::make(Boolean::class),
        ]);

        $payload->get('valid');
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
