<?php

namespace Infinity\Decorator\Database\Decorators;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class RelationsDecorator implements DecoratorContract
{
    /**
     * @param Builder|QueryBuilder $builder
     * @param $value
     * @param array|null $options
     * @return void
     */
    public function decorate($builder, $value, ?array $options = null): void
    {
        if (!is_string($value) || !$builder instanceof Builder) {
            return;
        }

        $builder->with(explode(',', $value));
    }
}