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

namespace Gocanto\Attributes;

use Exception;
use Throwable;

class AttributesException extends Exception
{
    /**
     * @param Throwable $exception
     * @param string $message
     * @return AttributesException
     */
    public static function fromThrowable(Throwable $exception, string $message = ''): AttributesException
    {
        $message = trim($message) === ''
            ? $exception->getMessage()
            : $message;

        return new static($message, (int) $exception->getCode(), $exception);
    }
}
