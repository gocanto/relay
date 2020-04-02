<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Promoter;
use Gocanto\Attributes\Tests\Stubs\Payload;
use Gocanto\Attributes\Types\Mixed;
use Gocanto\Attributes\Types\Text;
use Gocanto\Attributes\Types\Url;
use PHPUnit\Framework\TestCase;

class PromoterTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itAllowsOptionalsValues()
    {
        $data = [
            'name' => 'Gustavo',
        ];

        $rules = [
            'name' => Promoter::make(Text::class),
            'website' => Promoter::optional(Url::class),
        ];

        $payload = new Payload($data, $rules);

        $this->assertNull($payload->get('website'));

        /** @var Mixed $name */
        $name = $payload->get('name');

        $this->assertInstanceOf(Text::class, $name);
        $this->assertSame('Gustavo', $name->get());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstInvalidCandidates()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/does not exist/');

        Promoter::make('foo');
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstInvalidTypes()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/is not a valid type/');

        Promoter::make(Payload::class);
    }
}
