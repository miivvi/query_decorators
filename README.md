# Query Decorator

Превращает query-параметры HTTP-запроса в модификаторы билдера — чтобы разбор
`?limit=&sort=&with=` не писать в каждом контроллере.

```
GET /users?limit=10&sort=-created_at,name&with=roles
```

```php
$query->limit(10)
      ->orderBy('created_at', 'desc')
      ->orderBy('name', 'asc')
      ->with(['roles']);
```

## Установка

Регистрируется через auto-discovery. Конфиг обязателен к публикации — без него
декораторы не подхватятся и пакет молча не сделает ничего:

```bash
  php artisan vendor:publish --provider="Infinity\Decorator\Providers\QueryDecoratorServiceProvider"
```

## Использование

```php
use Infinity\Decorator\Database\Facades\QueryDecorator;

$query = User::query();

QueryDecorator::decorate($query);           // все параметры из конфига
QueryDecorator::decorate($query, ['sort']); // только sort, остальные игнорируются
```

Второй аргумент — whitelist **имён параметров** (не значений).

## Параметры

| Параметр | Пример                    | Действие                       | Builder          |
|----------|---------------------------|--------------------------------|------------------|
| `limit`  | `?limit=10`               | `->limit(10)`                  | Eloquent + Query |
| `sort`   | `?sort=-created_at,name`  | `->orderBy(...)`, `-` = `desc` | Eloquent + Query |
| `with`   | `?with=roles,orders`      | `->with([...])`                | только Eloquent  |

Набор задаётся в `config/query-decorator.php` — отдельно для Eloquent Builder
(`eloquent_decorators`) и Query Builder (`query_decorators`), нужный выбирается
по типу переданного билдера. `with` есть только у Eloquent, поэтому во втором
наборе его нет.

## Свой декоратор

```php
class StatusDecorator implements DecoratorContract
{
    public function decorate($builder, $value): void
    {
        $builder->where('status', $value);
    }
}
```

Зарегистрировать под именем query-параметра:

```php
'eloquent_decorators' => [
    'status' => \App\Decorators\StatusDecorator::class,
],
```

## Ограничения

- **`sort` и `with` не валидируются** — в `orderBy()` и `with()` попадает всё,
  что прислал клиент. Сортировка возможна по любой колонке таблицы, включая
  скрытые; eager-load — по любой связи модели. Несуществующая колонка или связь
  даёт 500. Список допустимых значений проверяй на входе (FormRequest) — пакет
  этого не делает.
- **`limit` без верхней границы** — клиент может запросить любой размер выборки.
- Пустые значения (`?sort=`) пропускаются.
- Пустой элемент в списке (`?sort=name,`) ломает SQL.
