# PHP-Csv

A simple PHP library for csv operation.

## Contents
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Examples](#examples)
- [LICENSE](#license)

## Requirements

- PHP 8.0.0 (CLI) or later
- Composer

## Installation

```bash
composer require macocci7/php-csv
```

## Usage

```php
<?php
```

## Methods
- load(): loads csv specified by the param
- save(): saves data into a csv file specified by the param
- encode(): encodes loaded csv data
- rows(): returns the count of rows of the csv
- columns(): returns the max count of columns of the csv
- bool(): specify the cast type for column() as (bool)
- int(): specify the cast type for column() as (int)
- float(): specify the cast type for column() as (float)
- string(): specify the cast type for column() as (string)
- raw(): unset the cast type for column()
- offset(): specify offset count for column()
- row(): retrieve the specified row as an array
- column(): retrieve the specified column as an array
- dump(): returns all data as csv
- dumpArray(): returns all data as an array

## Examples

preparing...

## LICENSE

[MIT](LICENSE)

***

*Document Created 2023/11/10*

*Document Updated 2023/11/10*
