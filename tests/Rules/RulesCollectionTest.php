<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Rules;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Rules\Constraint;
use Gocanto\Attributes\Rules\RulesCollection;
use Mockery;
use PHPUnit\Framework\TestCase;

class RulesCollectionTest extends TestCase
{
    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstDuplicateFieldRulesSet()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/constraints already exist/');

        $constraint = $this->getConstraintMock();

        $collection = new RulesCollection([
            'foo' => [$constraint],
        ]);

        $collection->add('foo', [$constraint]);
    }

    /**
     * @test
     * @throws AttributesException
     */
    public function itGuardsAgainstEmptyConstraints()
    {
        $this->expectException(AttributesException::class);
        $this->expectExceptionMessageMatches('/constraints are required/');

        $constraint = $this->getConstraintMock();

        $collection = new RulesCollection([
            'foo' => [$constraint],
        ]);

        $collection->add('bar', []);
    }

    /**
     * @return Constraint
     */
    private function getConstraintMock(): Constraint
    {
        $constraint = Mockery::mock(Constraint::class);
        $constraint->shouldReceive('getIdentifier')->andReturn('foo');

        return $constraint;
    }
}
