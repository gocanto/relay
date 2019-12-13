<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests;

use Gocanto\Attributes\Attributes;
use Gocanto\Attributes\Validator\Validator;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class AttributesTest extends TestCase
{
    /** @var Validator|LegacyMockInterface|MockInterface */
    private $validator;

    protected function setUp(): void
    {
        $this->validator = Mockery::mock(Validator::class);
    }

    /**
     * @test
     */
    public function itProperlySerializesDataAsArray()
    {
        $data = [
            'foo' => 'bar',
        ];

        $this->validator->shouldReceive('isEmpty')->once()->andReturn(true);

        $attr = new class($data) extends Attributes {
        };

        $this->assertEquals($attr->toArray(), $data);
    }

    /**
     * @test
     */
    public function itTriesToValidateTheGivenDataIfRulesWhereFound()
    {
        $data = [
            'foo' => 'bar',
        ];

        $this->validator->shouldReceive('isEmpty')->once()->andReturn(false);
        $this->validator->shouldReceive('validate')->once()->with($data);

        $attr = new class($data, $this->validator) extends Attributes {
        };

        $this->assertEquals($attr->toArray(), $data);
    }
}
