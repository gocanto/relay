<?php

declare(strict_types=1);

namespace Gocanto\Relay\Tests\Types;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Promoter;
use Gocanto\Relay\Tests\Stubs\Payload;
use Gocanto\Relay\Type;
use Gocanto\Relay\Types\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itReturnsValidUrls(): void
    {
        $payload = new Payload([
            'website' => 'https://github.com/gocanto',
        ], [
            'website' => Promoter::make(Url::class),
        ]);

        $website = $payload->get('website');
        $this->assertInstanceOf(Type::class, $website);
        $this->assertInstanceOf(Url::class, $website);
        $this->assertSame('https://github.com/gocanto', $website->get());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itRejectsInvalidUrls(): void
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/invalid/');

        new Payload([
            'website' => 'foo',
        ], [
            'website' => Promoter::make(Url::class),
        ]);
    }
}
