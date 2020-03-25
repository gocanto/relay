<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests;

use Gocanto\Attributes\Payload;
use Gocanto\Attributes\Types\Url;
use Gocanto\Attributes\Value;
use PHPUnit\Framework\TestCase;

class PayloadTest extends TestCase
{
    /**
     * @test
     */
    public function testingThisCode()
    {
        $data = [
            new Value('website', 'http://google.com', [Url::class]),
        ];

        $payload = new Payload($data);

        $website = $payload->get('website');

        $this->assertInstanceOf(Url::class, $website);
        $this->assertSame('http://google.com', $website->get());
    }
}
