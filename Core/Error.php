<?php

namespace Core;

use App\Error;

class Error {

    public static function errorHandler($level, $message, $file, $line) {
        $msg = [
            'message' => $messqge,
            'level' => $level,
            'file' => $file,
            'line' => $line
        ];
        $code = 0;
        $e = new \Exception();
        $e->code = $code;
        $e->msg = $msg;
        echo Error::exceptionHandler($e);
    }

}
