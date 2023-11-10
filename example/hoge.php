<?php

require_once('../vendor/autoload.php');

use Macocci7\PhpCsv\Csv;

$csv = new Csv();
$fn = 'csv/hoge.csv';
$csv->load($fn)->save();
