<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config {

    private static $production = true;    
    private static $mailError = false;
    private static $projectName = 'Meezzaa';
    private static $projectURL = '';
    private static $adminEmail = '';
    

    public static function getDataBaseCredentials() {
        if (static::$production) {
            return [
                'host' => 'localhost',
                'db' => '',
                'user' => '',
                'pass' => ''
            ];
        } else {
            return [
                'host' => 'localhost',
                'db' => '',
                'user' => '',
                'pass' => ''
            ];
        }
    }

    public static function getMailError() {
        return static::$mailError;
    }
    
    public static function getProjectURL() {
        return static::$projectURL;
    }
    
    public static function getProjectName() {
        return static::$projectName;
    }

    public static function setMode($mode) {
        ($mode == 'dev') ? static::$production = false : static::$production = true;
    }
    
    public static function getAdminEmail(){
        return static::$adminEmail;
    }
}
