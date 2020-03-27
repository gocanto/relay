<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Tests\Stubs\Payload;
use Gocanto\Attributes\Types\Promoter;
use Gocanto\Attributes\Types\Url;
use PHPUnit\Framework\TestCase;

class AttributesTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function testingThisCode()
    {

        $data = [
            'website' => 'http://google.com',
        ];

        $rules = [
            'website' => Promoter::make(Url::class),
            'profile_url' => Promoter::optional(Url::class),
        ];

        $payload = new Payload($data, $rules);

        $website = $payload->get('website');

        $this->assertInstanceOf(Url::class, $website);
        $this->assertSame('http://google.com', $website->get());
    }
}
