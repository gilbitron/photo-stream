# Photo Stream

A stupidly simple website generator for your photos. 

* Self hosted
* Static site
* No tracking
* Lazy loading
* Automatic image resizing

Heavily inspired by [maxvoltar/photo-stream](https://github.com/maxvoltar/photo-stream).

## Requirements

* PHP 7.0+
* GD Library (>=2.0) _or_ Imagick PHP extension (>=6.5.7)

## Usage

Getting started in two simple steps:

1. Add your photos to `/photos`
1. Run `./build`

The `/public` directory can now be deployed as a static site. The `./build` script should be run every time you deploy your site.

## Build Script

The `build` script does two things:

1 - Resizes the images in `/photos` and places them in:

* `/public/photos/large`
* `/public/photos/thumbs`

The size of the generated images can be customized in `config.php`.

2 - Generate a `/public/index.html` file from the template in `/template/index.php`. 

## Credits

Photo Stream was created by [Gilbert Pellegrom](https://gilbitron.me) from [Dev7studios](https://dev7studios.co). Released under the MIT license.
