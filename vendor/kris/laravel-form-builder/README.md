[![Build Status](https://img.shields.io/travis/kristijanhusak/laravel-form-builder/master.svg?style=flat)](https://travis-ci.org/kristijanhusak/laravel-form-builder)
[![Coverage Status](http://img.shields.io/scrutinizer/coverage/g/kristijanhusak/laravel-form-builder.svg?style=flat)](https://scrutinizer-ci.com/g/kristijanhusak/laravel-form-builder/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/kris/laravel-form-builder.svg?style=flat)](https://packagist.org/packages/kris/laravel-form-builder)
[![Latest Stable Version](https://img.shields.io/packagist/v/kris/laravel-form-builder.svg?style=flat)](https://packagist.org/packages/kris/laravel-form-builder)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)

# Laravel 5 form builder

Form builder for Laravel 5 inspired by Symfony's form builder. With help of Laravels FormBuilder class creates forms that can be easy modified and reused.
By default it supports Bootstrap 3.

## Laravel 4
For laravel 4 version check [laravel4-form-builder](https://github.com/kristijanhusak/laravel4-form-builder)

## Documentation
For detailed documentation refer to [http://kristijanhusak.github.io/laravel-form-builder/](http://kristijanhusak.github.io/laravel-form-builder/).

## Changelog
Changelog can be found [here](https://github.com/kristijanhusak/laravel-form-builder/blob/master/CHANGELOG.md)

###Installation

``` json
{
    "require": {
        "kris/laravel-form-builder": "1.6.*"
    }
}
```

run `composer update`

Then add Service provider to `config/app.php`

``` php
    'providers' => [
        // ...
        'Kris\LaravelFormBuilder\FormBuilderServiceProvider'
    ]
```

And Facade (also in `config/app.php`)

``` php
    'aliases' => [
        // ...
        'FormBuilder' => 'Kris\LaravelFormBuilder\Facades\FormBuilder'
    ]

```

**Notice**: This package will add `illuminate/html` package and load Aliases (Form, Html) if they do not exist in the IoC container


### Quick start

Creating form classes is easy. With a simple artisan command:

```sh
php artisan make:form Forms/SongForm --fields="name:text, lyrics:textarea, publish:checkbox"
```

Form is created in path `app/Forms/SongForm.php` with content:

```php
<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class SongForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text')
            ->add('lyrics', 'textarea')
            ->add('publish', 'checkbox');
    }
}
```

If you want to instantiate empty form without any fields, just skip passing `--fields` parameter:

```sh
    php artisan make:form Forms/PostForm
```

Gives:

```php
<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class PostForm extends Form
{
    public function buildForm()
    {
        // Add fields here...
    }
}
```

After that instantiate the class in the controller and pass it to view:

```php
<?php namespace App/Http/Controllers;

use Illuminate\Routing\Controller as BaseController;
use Kris\LaravelFormBuilder\FormBuilder;

class SongsController extends BaseController {

    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('App\Forms\SongForm', [
            'method' => 'POST',
            'url' => route('song.store')
        ]);

        return view('song.create', compact('form'));
    }
}
```

Print the form in view with `form()` helper function:

```html
<!-- resources/views/song/create.blade.php -->

@extend('layouts.master')

@section('content')
    {!! form($form) !!}
@endsection
```

Above code will generate this html:

```html
<form method="POST" action="http://example.dev/songs">
    <input name="_token" type="hidden" value="FaHZmwcnaOeaJzVdyp4Ml8B6l1N1DLUDsZmsjRFL">
    <div class="form-group">
        <label for="name" class="control-label">Name</label>
        <input type="text" class="form-control" id="name">
    </div>
    <div class="form-group">
        <label for="lyrics" class="control-label">Lyrics</label>
        <textarea name="lyrics" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="publish" class="control-label">Publish</label>
        <input type="checkbox" name="publish" id="publish">
    </div>
</form>
```

### Contributing
Project follows [PSR-2](http://www.php-fig.org/psr/psr-2/) standard and it's covered with PHPUnit tests.
Pull requests should include tests and pass [Travis CI](https://travis-ci.org/kristijanhusak/laravel-form-builder) build.

To run tests first install dependencies with `composer install`.

After that tests can be run with `vendor/bin/phpunit`
