<?php declare(strict_types=1);

/*
 * This file is part of the Gocanto Attributes Package
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gocanto\Attributes\Tests;

use Gocanto\Attributes\AttributeException;
use Gocanto\Attributes\Tests\Stubs\DummyAttributes;
use PHPUnit\Framework\TestCase;

class AttributesTest extends TestCase
{
    /**
     * @test
     * @throws AttributeException
     */
    public function itGuardsAgainstEmptyAttributes()
    {
        $this->expectException(AttributeException::class);

        new DummyAttributes([]);
    }

    /**
     * @test
     * @throws AttributeException
     */
    public function itGuardsAgainstRequiredValues()
    {
        $this->expectException(AttributeException::class);

        new DummyAttributes([
            'name' => '',
        ]);
    }
}
