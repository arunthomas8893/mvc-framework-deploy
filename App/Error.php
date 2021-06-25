<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

use App\Models\Common\Logger;
use App\Config;
use Core\Controller;
use App\Models\Common\Values;
use Core\View;

class Error {

    public static function errorHandler($level, $message, $file, $line) {
        $msg = [
            'message' => $messqge,
            'level' => $level,
            'file' => $file,
            'line' => $line
        ];
        $code = 0;
        throw new \Exception($msg, $code);
    }

    private static function processErrorMessage($ex) {
        $code = $ex->getCode();
        $msg = "";
        switch ($code) {
            case Values::$resCode_validationError:
                $msg = "Invalid Request";
                break;
            case Values::$resCode_notAuthenticated:
                $msg = "You are not authorized";
                break;
            case Values::$resCode_notFound:
                $msg = "Sorry, resource doesn't exist.";
                break;
            case Values::$resCode_userExists:
                $msg = $ex->getMessage();
                break;
            case Values::$resCode_loginFailure:
                $msg = $ex->getMessage();
                break;
            default:
                $code = 500;
                $msg = 'An error occured!';
        }
        return $msg;
    }

    public static function exceptionHandler(\Throwable $ex) {
        $log = new Logger();
        $log->logErrorWithOutMailing($ex, Config::getProjectName());
        $code = $ex->getCode();
        $msg = static::processErrorMessage($ex);
       
        if (!Controller::$ajaxRequest) {
            
            if ($code != Values::$resCode_notAuthenticated) {
                return View::renderTemplate("errorDisplayer.html", [
                            'code' => $code,
                            'msg' => $msg
                ]);
            } else {
                $_SESSION['previousURL'] = $_SERVER['REQUEST_URI'];
                header('Location:/authentication/login');
            }
        } else {
            return Controller::generateResponseJson($code, '', $msg);
        }
    }

}
