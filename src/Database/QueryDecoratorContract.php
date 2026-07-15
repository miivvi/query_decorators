<?php

namespace Infinity\Decorator\Database;

use Illuminate\Database\Eloquent\Builder;

interface QueryDecoratorContract
{
    /**
     * @param Builder $builder
     * @param array|null $only
     * @return void
     */
    public function decorate(Builder $builder, ?array $only = null): void;
}