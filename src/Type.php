<?php

declare(strict_types=1);

namespace Gocanto\Relay;

interface Type
{
    /**
     * @param mixed $value
     * @return static
     * @throws AttributesException
     */
    public static function make($value): self;

    /**
     * @return mixed
     */
    public function get();
}
