<?php

namespace Infinity\Decorator\Database\Facades;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void decorate(Builder|QueryBuilder $builder, ?array $options = null)
 *
 * @see \Infinity\Decorator\Database\QueryDecorator
 */
class QueryDecorator extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Infinity\Decorator\Database\QueryDecorator::class;
    }
}