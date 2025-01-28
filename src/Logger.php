<?php

namespace App;

use App\Interfaces\Log;

final class Logger implements Log
{
    public static function log(string $message, string $type = 'info'): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $formattedMessage = "[$timestamp] ($type) $message" . PHP_EOL;

        file_put_contents('logs.txt', $formattedMessage, FILE_APPEND);
    }
}
