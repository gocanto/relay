<?php

declare(strict_types=1);

/*
 * This file is part of the Gocanto Attributes Package
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gocanto\Converter\Tests;

use Gocanto\Attributes\Tests\Stubs\DummyAttributes;
use PHPUnit\Framework\TestCase;

class AttributesTest extends TestCase
{
    /** @var array */
    private $fillable;

    protected function setUp(): void
    {
        $this->fillable = [
            'foo',
            'bar',
        ];
    }

    /**
     * @test
     */
    public function itHoldsTheRequiredData()
    {
        $dummy = new DummyAttributes([]);

        $this->assertEquals($this->fillable, $dummy->getFillable());
    }

    /**
     * @test
     */
    public function itCheckForExistingValues()
    {
        $dummy = new DummyAttributes([
            'bar' => '001',
            'foo' => null,
            'biz' => '',
            'gus' => ' ',
        ]);

        $this->assertFalse($dummy->filled('foo'));
        $this->assertFalse($dummy->filled('biz'));
        $this->assertFalse($dummy->filled('MISSING-KEY'));

        $this->assertTrue($dummy->filled('bar'));
        $this->assertTrue($dummy->filled('gus'));
    }
}
