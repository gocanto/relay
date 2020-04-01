<?php

declare(strict_types=1);

namespace Gocanto\Attributes;

interface Type
{
    public static function make($value): self;

    /**
     * @return mixed
     */
    public function get();
}
