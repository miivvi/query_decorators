<?php

namespace Infinity\Decorator\Database;

use Infinity\Decorator\Database\Decorators\DecoratorContract;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class QueryDecorator implements QueryDecoratorContract
{
    /**
     * @var array|string[]
     */
    protected array $decorators = [];

    /**
     * @var Container
     */
    protected Container $container;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * QueryDecorator constructor.
     * @param Request $request
     * @param Container $container
     */
    public function __construct(Request $request, Container $container)
    {
        $this->request = $request;
        $this->container = $container;
    }

    /**
     * @param Builder|QueryBuilder $builder
     * @param array|null $only
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function decorate($builder, ?array $only = null): void
    {
        if (!$this->validateBuilder($builder)) {
            return;
        }

        $this->resolveDecorators($builder);

        foreach ($this->request->query->all() as $name => $value) {
            if (empty($value)
                || (!is_null($only) && !in_array($name, $only))
            ) {
                continue;
            }

            $decorator = $this->pickDecorator($name);

            if (!$decorator instanceof DecoratorContract) {
                continue;
            }

            $decorator->decorate($builder, $value);
        }
    }

    /**
     * @param $builder
     * @return bool
     */
    private function validateBuilder($builder): bool
    {
        return $builder instanceof Builder || $builder instanceof QueryBuilder;
    }

    /**
     * @param string $name
     * @return DecoratorContract|null
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function pickDecorator(string $name): ?DecoratorContract
    {
        if (!Arr::has($this->decorators, $name)) {
            return null;
        }

        return $this->container->get(Arr::get($this->decorators, $name));
    }

    /**
     * @param $builder
     * @return void
     */
    private function resolveDecorators($builder): void
    {
        $set = $builder instanceof Builder ? 'eloquent_decorators' : 'query_decorators';

        $this->decorators = config('query-decorator.' . $set, []);
    }
}