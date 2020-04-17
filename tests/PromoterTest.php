<?php

declare(strict_types=1);

namespace Gocanto\Attributes\Tests;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Promoter;
use Gocanto\Attributes\Tests\Stubs\Payload;
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
