<?php

namespace App\Support\Helper;

final class DateTimeHelper
{
    private static string $format = 'Y-m-d H:i:s';

    public function __construct() {
    }

    public static function getDate(): string
    {
        return date(self::$format);
    }
}