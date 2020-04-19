<?php

declare(strict_types=1);

namespace Gocanto\Relay\Tests;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Promoter;
use Gocanto\Relay\Tests\Stubs\Payload;
use Gocanto\Relay\Types\Any;
use Gocanto\Relay\Types\Text;
use Gocanto\Relay\Types\Url;
use PHPUnit\Framework\TestCase;

class AttributesTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itReturnsValidValues()
    {
        $url = 'https://github.com/gocanto';

        $payload = new Payload([
            'website' => $url,
        ], [
            'website' => Promoter::make(Url::class),
        ]);

        $website = $payload->get('website');

        $this->assertInstanceOf(Url::class, $website);
        $this->assertSame($url, $website->get());
        $this->assertEquals(['website' => Url::make($url)], $payload->toArray());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itReturnsNullForValuesThatAreNotRequired()
    {
        $payload = new Payload([
            'name' => 'gustavo',
        ], [
            'name' => Promoter::make(Text::class),
        ]);

        $this->assertNull($payload->get('foo'));
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itThrowsExceptionsIfAttributesDontContainGivenRulesFields()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/required/');

        $payload = new Payload([
            'last_name' => 'gustavo',
        ], [
            'name' => Promoter::make(Text::class),
        ]);

        $payload->get('name');
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itWrapsUntypedValuesWithinAMixedType()
    {
        $payload = new Payload([
            'name' => 'gustavo',
            'last_name' => 'ocanto',
        ], [
            'last_name' => Promoter::make(Text::class),
        ]);

        $lastName = $payload->get('last_name');
        $this->assertInstanceOf(Text::class, $lastName);
        $this->assertSame('ocanto', $lastName->get());

        $name = $payload->get('name');
        $this->assertInstanceOf(Any::class, $name);
        $this->assertSame('gustavo', $name->get());
    }

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

        /** @var Any $name */
        $name = $payload->get('name');

        $this->assertInstanceOf(Text::class, $name);
        $this->assertSame('Gustavo', $name->get());
    }
}
