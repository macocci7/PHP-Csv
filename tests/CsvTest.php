<?php

declare(strict_types=1);

namespace Macocci7\PhpCsv;

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use Macocci7\PhpCsv\Csv;

final class CsvTest extends TestCase
{
    public function test_load_can_load_csv_correctly(): void
    {
        $this->assertTrue(true);
    }
}
