<?php

declare(strict_types=1);

namespace Gocanto\Attributes;

interface Type
{
    public static function make($value): self;

    public static function identifier(): string;

    public static function constraints(): array;

    /**
     * @return mixed
     */
    public function get();
}
