<?php

namespace Infinity\Decorator\Database\Decorators;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * Options:
 *  sort_map: array of map query param to DB field
 */
class SortDecorator implements DecoratorContract
{
    /**
     * @param Builder|QueryBuilder $builder
     * @param $value
     * @return void
     */
    public function decorate($builder, $value): void
    {
        foreach (explode(',', $value) as $option) {
            [$field, $direction] = $this->parseSortOption($option);
            $builder->orderBy($field, $direction);
        }
    }

    /**
     * @param string $option
     * @return array
     */
    private function parseSortOption(string $option): array
    {
        $direction = 'asc';
        if (substr($option, 0, 1) === '-') {
            $option = substr($option, 1);
            $direction = 'desc';
        }

        return [$option, $direction];
    }
}