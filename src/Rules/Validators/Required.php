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

use Gocanto\Attributes\Rules\Constraint;

class Required implements Constraint
{
    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'required';
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function canReject($value): bool
    {
        return empty($value);
    }
}
