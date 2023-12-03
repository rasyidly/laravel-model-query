# Laravel Model Query

Advanced laravel dynamic model queries

## Installation

Install this package with composer

```bash
composer require rasyidly/laravel-model-query
```

## Usage

There are several features including this package. To use all features, use this as trait as following example.

```php
use Rasyidly/ModelQuery/ModelQuery;

class User extends Model
{
    /**
     * This will load Loadable, Searchable, Sortable, and Trashable Traits in single load.
     */
    use ModelQuery;
}
```

#### OR, manually use single feature as trait

Just use feature/s as a trait to your Model, e.g.:

```php
use Rasyidly/ModelQuery/Loadable/Loadable;
use Rasyidly/ModelQuery/Searchable/Searchable;

class User extends Model
{
    use Loadable, Searchable;
}
```

## Features

There are main feature of this package features and how-to-use.

### 📃 Loadable

Loadable is a trait that functions to load eloquent relations based on the `$loadable` property defined in the Model, like this:

```php
class Post extends Model
{
    use ModelQuery;

    public $loadable = [
        'author.profile', 'commentable'
    ];

    public function author (): BelongsTo { ... }
}
```

If the relationship is not found in the definition, it will not give an error. Unless you give the wrong definition of the relationship, it is fatal.

Then, for use in the Controller, as follows:

#### Eager loading

```php
// posts?load=author,commentable

$query = ['author', 'commentable'];

$posts = Post::loadable($request->query('load'))->get();
```

This will produce a collection/object of `Post` with the relations `author` and `commentable` by eager loading. Make sure the query is separated with comma if load more than one relation, so that loadable accepts array parameters according to Loadable's terms.

#### Lazy loading

It's the same, the only difference is that it will be loaded when it becomes an object (not a query builder a.k.a. n+1)

```php
// posts?load=author.profile

$post = Post::find(1);

$query = ['author.profile'];
$post = $post->loadable($request->query('load'));
```

This will load the `author.profile` relation as per the `$loadable` definition.

### 📃 Searchable

Searchable is a trait that functions to search for specific text based on the `$searchable` property defined in the Model, like this:

```php
class Post extends Model
{
    use ModelQuery;

    public $searchable = [
        'title', 'description', 'author.name'
    ];

    public function author (): BelongsTo { ... }
}
```

With this searchable definition, in sequence, it will search for a collection of Posts where `title like % ... %`, and so on. You can also use a relationship like the example above, `author.name`, meaning it will look for `name` in the `author` relationship

Then, for use in the Controller, as follows:

```php
// posts?search=Hello

$posts = Post::searchable($request->query('search'))->get();
```

The result of the syntax above is to search for posts in the column defined by `$searchable`, in this case it will search like "%Hello%" in the `title` or `description` column or `name` in the `author` relationship

### 📃 Sortable

The sortable feature is a method for sorting by columns defined in the `$sortable` property, with the addition of `,asc` or `,desc`.

```php
class Post extends Model
{
    use ModelQuery;

    public $sortable = [
        'name'
    ];
}
```

An example of implementation in the Controller is as follows:

```php
// posts?sort=name,asc

$posts = Post::sortable($request->query('sort'))->get();
```

Basically, sortable is exactly like Laravel's built-in `orderBy` method, only I combine the sorting method, whether ascending or descending. This trait only accepts two ascending or descending parameters, otherwise it will ignore this method, no error will be displayed.

### 📃 Trashable

This trait only works if the Model uses `SoftDeletes`

There are no additional special properties like in the previous trait. This will only add a special method namely `trashable($default = 'without')` which only accepts 3 parameters namely `with`, `only`, and `without`.

The implementation is as follows:

```php
// posts?trash=only

$posts = Post::trashable($request->query('trash'))->get();
```

The result of the query and syntax is that it will only call `onlyTrashed` from Laravel SoftDeletes.

## Contributing

Contributions are always welcome, just open issues, fork and/or pull your request! Up to you!

## License

This library is open-source software licensed under the [MIT](https://choosealicense.com/licenses/mit/)
