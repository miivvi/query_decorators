<?php

    return [
        'eloquent_decorators' => [
            'limit' => \Infinity\Decorator\Database\Decorators\LimitDecorator::class,
            'with' => \Infinity\Decorator\Database\Decorators\RelationsDecorator::class,
            'sort' => \Infinity\Decorator\Database\Decorators\SortDecorator::class,
        ],

        'query_decorators' => [
            'limit' => \Infinity\Decorator\Database\Decorators\LimitDecorator::class,
            'sort' => \Infinity\Decorator\Database\Decorators\SortDecorator::class,
        ],
    ];