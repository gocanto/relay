<?php

declare(strict_types=1);

namespace Gocanto\Relay\Tests\Types;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Promoter;
use Gocanto\Relay\Tests\Stubs\Payload;
use Gocanto\Relay\Types\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itHoldsValidEmail(): void
    {
        $payload = new Payload([
            'email' => 'foo@bar.com',
        ], [
            'email' => Promoter::make(Email::class),
        ]);

        /** @var Email $email */
        $email = $payload->get('email');
        $this->assertInstanceOf(Email::class, $email);
        $this->assertSame('foo@bar.com', $email->get());
        $this->assertSame('bar.com', $email->getDomain());
        $this->assertSame('com', $email->getTLD());
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itRejectsInvalidEmails(): void
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/invalid/');

        new Payload([
            'email' => 'foo',
        ], [
            'email' => Promoter::make(Email::class),
        ]);
    }
}
