<?php

declare(strict_types=1);

namespace Gocanto\Relay\Tests;

use Gocanto\Relay\AttributesException;
use Gocanto\Relay\Promoter;
use Gocanto\Relay\Tests\Stubs\Payload;
use Gocanto\Relay\Types\Url;
use PHPUnit\Framework\TestCase;

class PromoterTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itAllowsOptionalsValues()
    {
        $promoter = Promoter::optional(Url::class);

        $this->assertFalse($promoter->isRequired());
        $this->assertSame(Url::class, $promoter->getCandidate());
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
