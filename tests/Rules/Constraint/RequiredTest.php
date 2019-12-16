<?php declare(strict_types=1);

namespace Gocanto\Attributes\Tests\Rules\Constraint;

use Gocanto\Attributes\Rules\Constraint;
use Gocanto\Attributes\Rules\Validators\Required;
use PHPUnit\Framework\TestCase;

class RequiredTest extends TestCase
{
    /**
     * @test
     */
    public function itHoldsValidData()
    {
        $constraint = new Required;

        $this->assertInstanceOf(Constraint::class, $constraint);

        $this->assertSame('required', $constraint->getIdentifier());

        $this->assertTrue($constraint->canReject(''));
        $this->assertTrue($constraint->canReject(null));

        $this->assertFalse($constraint->canReject('foo'));
    }
}
