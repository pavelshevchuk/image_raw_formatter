Image Raw Field Formatter
=====================
[![Build Status](https://travis-ci.org/dmouse/vimeo-field.svg?branch=master)](https://travis-ci.org/dmouse/vimeo-field)

Vimeo Field Formatter for Drupal 8

### Install
```bash
$ cd path/to/drupal/8/modules
$ git clone https://github.com/enzolutions/image-raw-formatter.git
$ drush en -y image_raw_formatter # or enable this module via UI
```

### Usage

 * In your content type create a new Image field
 * Go to /admin/structure/types/manage/[Content-Type]/display
 * Change the format field to use Image Raw formatter

Resources
---------

You can run the unit tests with the following command:

    $ composer install
    $ vendor/bin/phpunit
