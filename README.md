<h4 style="text-align: center">Mediabox</h4>

---

### About Mediabox
Mediabox is a PHP implementation of a __web-based file management system__. The library makes it easy to interact with the local disk storage's files and folders.

Features include:

* Adding of files and folders
* Copying
* Deleting files from disk
* Displaying and downloading files from browser
* Renaming and Moving files and folders.
* Toggling of hidden files
* Easy syntax to retrieve file meta info like size, permission, last modified date, owner, etc.

<br>

### Demonstration
_This section is under development._

<br>

### Requirements

* `PHP`: `7+`
* `illuminate/filesystem`: `^7.11`

<br>

---

<br>

### Installation

The library can be installed via composer:
```bash
composer require codrasil/mediabox
```

It can also be used as a <a href="https://github.com/laravel/laravel">Laravel</a> package and can be auto-discovered by Laravel.

##### Publishing Configuration
If used in a Laravel project, the configuration file can be published via `artisan` command:

```bash
php artisan vendor:publish --provider="Codrasil\Mediabox\MediaboxServiceProvider"
```

See <a href="./docs/Laravel.md">docs/Laravel.md</a> for instructions on how to setup in a Laravel project.

<br>

---

<br>

### Usage

##### Plain PHP

```php
use Codrasil\Mediabox\Mediabox;

...

$baseStoragePath = '/path/to/a/storage/folder';

$mediabox = new Mediabox($baseStoragePath);

$mediabox->showHiddenFiles($yes = true);

foreach ($mediabox->all() as $file) {
    if ($file->isDir()) {
        echo $file->name().'/'.PHP_EOL;
    } else {
        echo $file->name().PHP_EOL;
    }
}
```

##### Laravel

If using within a Laravel project, just inject the `Codrasil\Mediabox\Mediabox` class to a controller or another class.

```php
// routes/web.php

use Codrasil\Mediabox\Mediabox;
use Illuminate\Http\Request;

Route::get('media', function (Request $request, Mediabox $mediabox) {
    return view('path.to.a.view')->withMediabox($mediabox);
});
```

```blade
{{-- resources/views/path/to/a/view.blade.php --}}

@foreach ($mediabox->all() as $file)
  @if ($file->isDir())
    <p><i class="{{ $file->icon() }}">&nbsp;</i>{{ $file->name() }}/</p>
  @else
    <p><i class="{{ $file->icon() }}">&nbsp;</i>{{ $file->name() }}</p>
  @endif
@endforeach
```

Note by default, the library will list the files and folders listed in `storage/app/public`.
To change the path, update the `root_path` value in `config/mediabox.php` file.

<br>

All the necessary setup is taken cared of by the `Codrasil\Mediabox\MediaboxServiceProvider` class.

See `config/mediabox.php` to specify the `root_path`.
The default value will point to the `storage_path('app/public')`, so make sure to create the folder.

Operations like adding, copying, and deleting of files are registered as an API route by default.
And displaying and downloading of file is registered as a web route.

```bash
> php artisan route:list
+----------+-----------------------------+------------------+--------------------------------------------------------------+--------------+
| Method   | URI                         | Name             | Action                                                       | Middleware   |
+----------+-----------------------------+------------------+--------------------------------------------------------------+--------------+
| GET|HEAD | api/v1/media                | api.media.index  | Codrasil\Mediabox\Http\Controllers\MediaboxController@index  | api,bindings |
| POST     | api/v1/media/add            | api.media.add    | Codrasil\Mediabox\Http\Controllers\MediaboxController@add    | api,bindings |
| DELETE   | api/v1/media/delete         | api.media.delete | Codrasil\Mediabox\Http\Controllers\MediaboxController@delete | api,bindings |
| PATCH    | api/v1/media/move           | api.media.move   | Codrasil\Mediabox\Http\Controllers\MediaboxController@move   | api,bindings |
| GET|HEAD | api/v1/media/{media}        | api.media.show   | Codrasil\Mediabox\Http\Controllers\MediaboxController@show   | api,bindings |
| POST     | api/v1/media/{media}/copy   | api.media.copy   | Codrasil\Mediabox\Http\Controllers\MediaboxController@copy   | api,bindings |
| PATCH    | api/v1/media/{media}/rename | api.media.rename | Codrasil\Mediabox\Http\Controllers\MediaboxController@rename | api,bindings |
| GET|HEAD | storage/{file}              | storage.show     | Codrasil\Mediabox\Http\Controllers\ShowStorageFile           | web          |
| GET|HEAD | storage/{file}/download     | storage.download | Codrasil\Mediabox\Http\Controllers\DownloadStorageFile       | web          |
+----------+-----------------------------+------------------+--------------------------------------------------------------+--------------+
```

<br>

#### Adding
```php
$mediabox->addFolder('Reminders');
$mediabox->addFile('Reminders/groceries.todo', 'Milk');
```
Adding folders is recursive by default.

<br>

#### Copying
The `copy` method accepts the relative path of the file to be copied as first argument.
The second argument is the new file name.

```php
$mediabox->copy('Reminders/groceries.todo', 'Copy of groceries.todo');

$mediabox->copy('Reminders', 'Copy of Reminders');
// or
$mediabox->copyDirectory('Reminders', 'Copy of Reminders');

```

<br>

#### Moving or renaming
The `rename` and `move` methods accept a `$path` and `$target` destination.
```php
$mediabox->rename('Reminders/groceries.todo', 'Reminders/My Grocery List.todo');
// or
$mediabox->move('Reminders/groceries.todo', 'Reminders/My Grocery List.todo');
```

<br>

#### Deleting
The `delete` method can accept a path or array of paths.
```php
$mediabox->delete('Copy of Reminders');
$mediabox->delete('Copy of groceries.todo');
// or
$mediabox->delete(['Copy of Reminders', 'Copy of groceries.todo']);
```

<br>

#### Displaying & Downloading
To display a file on a browser, use the `fetch` method.
```php
$mediabox->fetch('/path/to/a/file.txt');
```

To force browser to download the file, use the `download` method.
```php
$mediabox->download('/path/to/a/file.txt');
```

Both methods will return an instance of `Symfony\Component\HttpFoundation\BinaryFileResponse`.

<br>
