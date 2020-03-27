<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Promoter;
use Gocanto\Attributes\Tests\Stubs\Payload;
use Gocanto\Attributes\Types\Mixed;
use Gocanto\Attributes\Types\Url;
use PHPUnit\Framework\TestCase;

class AttributesTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itReturnsTheExpectedData()
    {
        $data = [
            'website' => 'https://github.com/gocanto',
        ];

        $rules = [
            'website' => Promoter::make(Url::class),
        ];

        $payload = new Payload($data, $rules);

        $website = $payload->get('website');
        $this->assertInstanceOf(Url::class, $website);
        $this->assertSame('https://github.com/gocanto', $website->get());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itRequiresValuesIfRulesAreGivenAndPayloadsAreIncomplete()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/required/');

        $data = [
            'name' => 'Gustavo',
        ];

        $rules = [
            'website' => Promoter::make(Url::class),
        ];

        $payload = new Payload($data, $rules);

        $website = $payload->get('website');
    }
}
