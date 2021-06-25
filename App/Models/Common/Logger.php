<?php

namespace App\Models\Common;

use App\Config;

class Logger {

    private $errorLogPath;
    private $errorLoggingEmail;
    private $errorLogSubject;

    public function __construct() {
        $this->errorLogPath = $_SERVER['DOCUMENT_ROOT'] . '/logs/error.log';
        $this->errorLoggingEmail = "saijoge@gmail.com";
        $this->errorLogSubject = 'ERROR : '.Config::getProjectName();
    }

    public function logError(\Throwable $e, string $errtype) {

        $errno = $e->getCode();
        $errstr = $e->getMessage();
        $errfile = $e->getFile();
        $errline = $e->getLine();
        $file = fopen($this->errorLogPath, "a");
        $dateTime = DateTimeWrapper::newDateInIndianFormat();
        echo fwrite($file, " \r\n$dateTime*****[$errtype]--$errno:  $errstr in $errfile on line $errline");
        $trace = $e->getTraceAsString();
        $errorMessageForMailing = $this->formatErrorForMailing($errtype, $dateTime, $errno, $errstr, $errfile,
                $errline, $trace);
             
        $email = new Mailer();
        $emailDeliveryStatus = $email->SendEmail($this->errorLoggingEmail,
                $this->errorLogSubject, $errorMessageForMailing);
        if ($emailDeliveryStatus != '1') { 
            throw new \Exception(' Error occured while sending email to ' . $To, Values::$resCode_emailSendingError);
        } else {
            return '101';
        }

        unset($email);
    }
    
    public function logErrorWithOutMailing(\Throwable $e, $errtype) {

        $errno = $e->getCode();
        $errstr = $e->getMessage();
        $errfile = $e->getFile();
        $errline = $e->getLine();
        $etrace = $e->getTraceAsString();
        $file = fopen($this->errorLogPath, "a");
        $dateTime = DateTimeWrapper::newDateInIndianFormat();
        fwrite($file, " \r\n$dateTime*****[$errtype]--$errno:  $errstr in $errfile on line $errline".PHP_EOL);
        fwrite($file, $etrace, FILE_APPEND);
        fclose($file);
    }

    public function logEmailError(\Throwable $e, $errtype) {
        $errno = $e->getCode();
        $errstr = $e->getMessage();
        $errfile = $e->getFile();
        $errline = $e->getLine();
        $etrace = $e->getTraceAsString();
        $file = fopen($this->errorLogPath, "a");
        $dateTime = DateTimeWrapper::newDateInIndianFormat();
        fwrite($file, " \r\n$dateTime*****[$errtype]--$errno:  $errstr in $errfile on line $errline");
        fwrite($file, $etrace, FILE_APPEND);
        fclose($file);
    }

    public function logErrorForPhpMailer($e, $errtype) {
        $file = fopen($this->errorLogPath, "a");
        $dateTime = DateTimeWrapper::newDateInIndianFormat();
        fwrite($file, " \r\n$dateTime*****[$errtype]----$e");
        fclose($file);
    }

    public function formatErrorForMailing($errtype, $dateTime, $errno, $errstr, $errfile, $errline, $trace) {

        $content = " 
  <table style=border:1px solid #f00;background-color:#eee;>
  <tbody>
  <tr><th style=border:1px solid #999;color:#00d;text-align:left>Date</th><td style=border:1px solid #999;color:#222;text-align:left>$dateTime</td></tr>
  <tr><th style=border:1px solid #999;color:#00d;text-align:left>Error From</th><td style=border:1px solid #999;color:#222;text-align:left>$errtype</td></tr>
  <tr><th style=border:1px solid #999;color:#00d;text-align:left>Error</th><td style=border:1px solid #999;color:#222;text-align:left>$errstr</td></tr>
  <tr><th style=border:1px solid #999;color:#00d;text-align:left>Errno</th><td style=border:1px solid #999;color:#222;text-align:left>$errno</td></tr>
  <tr><th style=border:1px solid #999;color:#00d;text-align:left>File</th><td style=border:1px solid #999;color:#222;text-align:left>$errfile</td></tr>
  <tr><th style=border:1px solid #999;color:#00d;text-align:left>Line</th><td style=border:1px solid #999;color:#222;text-align:left>$errline</td></tr>
  <tr><th style=border:1px solid #999;color:#00d;text-align:left>Trace</th><td style=border:1px solid #999;color:#222;text-align:left><pre>$trace</pre></td></tr>
  </tbody>
  </table>
   ";
        return $content;
    }

}
