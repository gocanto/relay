<?php declare(strict_types=1);

/*
 * This file is part of the Gocanto Attributes Package
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gocanto\Attributes\Rules\Validators;

use Gocanto\Attributes\AttributesException;
use Gocanto\Attributes\Rules\Constraint;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

class IntegerRule implements Constraint
{
    /**
     * @inheritDoc
     */
    public function getIdentifier(): string
    {
        return 'integer';
    }

    /**
     * @inheritDoc
     */
    public function assert($value, $message = ''): void
    {
        try {
            Assert::integer($value, $message);
        } catch (InvalidArgumentException $exception) {
            throw AttributesException::fromThrowable($exception, $message);
        }
    }
}
