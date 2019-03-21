# BackPackImageUpload

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require viralsbackpack/backpackimageupload
```

Run command:
```bash
php artisan vendor:publish --provider="ViralsBackpack\BackPackImageUpload\BackPackImageUploadServiceProvider"

php artisan migrate
```
Create the symbolic link, run command:
```bash
php artisan storage:link
```

## Config
Config package in ```config/backpackimageupload.php```.

## Usage
Add trait ```ViralsBackpack\BackPackImageUpload\Traits\HasImages``` to model has image, Eg:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use ViralsBackpack\BackPackImageUpload\Traits\HasImages;// <------------------------------- this one

class Tag extends Model
{
    use CrudTrait;
    use HasImages; // <------------------------------- this one

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tags';
    protected $fillable = ['name'];
}
```

Add field:
```php
$this->crud->addField([
    'name' => 'images',
    'label' => 'Images',
    'type' => 'virals_browse_image',
]);

```
Package support upload image and pick uploaded image in server

Function provide:

Initialize the model

```php
$model = Test::find($id);
```
Get all Image for model

```php
$model->images;
```


Create Image

```php
$model->createImage($params);
```

Update Image  

```php
$model->updateImage($params);
```
Delete Image:(delete image file and record)   

```php
$model->updateImage($params);
```
$params: array($link1, $link2) or string url image
## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.


## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/viralsbackpack/backpackimageupload.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/viralsbackpack/backpackimageupload.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/viralsbackpack/backpackimageupload/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/viralsbackpack/backpackimageupload
[link-downloads]: https://packagist.org/packages/viralsbackpack/backpackimageupload
[link-travis]: https://travis-ci.org/viralsbackpack/backpackimageupload
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/viralsbackpack
[link-contributors]: ../../contributors
