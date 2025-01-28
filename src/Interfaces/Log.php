<?php

namespace App\Interfaces;

interface Log
{
    public static function log(string $message, string $type = 'info'): void;
}
