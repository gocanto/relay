<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Types;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Promoter;
use Gocanto\Attributes\Tests\Stubs\Payload;
use Gocanto\Attributes\Type;
use Gocanto\Attributes\Types\Url;
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
