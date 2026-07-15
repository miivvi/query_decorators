<?php

namespace Infinity\Decorator\Database\Decorators;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

interface DecoratorContract
{
    /**
     * @param Builder|QueryBuilder $builder
     * @param $value
     * @return void
     */
    public function decorate($builder, $value): void;
}