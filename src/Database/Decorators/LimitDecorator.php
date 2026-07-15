<?php

namespace Infinity\Decorator\Database\Decorators;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class LimitDecorator implements DecoratorContract
{
    /**
     * @param Builder|QueryBuilder $builder
     * @param $value
     * @return void
     */
    public function decorate($builder, $value): void
    {
        if ($value <= 0) {
            return;
        }

        $builder->limit($value);
    }
}