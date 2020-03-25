<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests;

use Gocanto\Attributes\Tests\Stubs\Payload;
use Gocanto\Attributes\Types\Url;
use PHPUnit\Framework\TestCase;

class PayloadTest extends TestCase
{
    /**
     * @test
     */
    public function testingThisCode()
    {

        $data = [
            'website' => 'http://google.com',
        ];

        $rules = [
            'website' => [Url::class],
        ];

        $payload = new Payload($data, $rules);

        $website = $payload->get('website');

        $this->assertInstanceOf(Url::class, $website);
        $this->assertSame('http://google.com', $website->get());
    }
}
