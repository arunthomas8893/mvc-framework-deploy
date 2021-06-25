<?php

namespace App\Models\Common;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {

    private $emailId = '';
    private $emailPassword = '';
    private $emailFrom = '';
    private $emailServer = '';
    private $emailPort = '';
    private $emailProtocol = '';

    public function __construct() {
        $this->emailId = '';
        $this->emailPassword = '';
        $this->emailFrom = '';
        $this->emailServer = '';
        $this->emailPort = '';
        $this->emailProtocol = '';
    }

    public function SendEmail($To, $Subject, $Message) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = '';
        $mail->SMTPSecure = '';
        $mail->Port = '';
        $mail->SMTPAuth = true;
        $mail->Username = $this->emailId;
        $mail->Password = $this->emailPassword;
        $mail->setFrom($this->emailId, $this->emailFrom);
        $mail->addAddress($To);
        $mail->isHTML(true);
        $mail->Subject = $Subject;
        $mail->Body = $Message;
        if (!$mail->send()) {
            $log = new Logger();
            $log->logErrorForPhpMailer($mail->ErrorInfo, 'Email');
            throw new \Exception(' Error occured while sending email to ' . $To, Values::$resCode_emailSendingError);
        } else {
            return '1';
        }
    }

    public function SendEmailAttachment($To, $Subject, $Message, string $attachment, string $attachname) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = '';
        $mail->SMTPAuth = true;
        $mail->Username = $this->emailId;
        $mail->Password = $this->emailPassword;
        $mail->setFrom($this->emailId, $this->emailFrom);
        $mail->addAddress($To);
        $mail->isHTML(true);
        $mail->Subject = $Subject;
        $mail->Body = $Message;
        $mail->addAttachment($attachment, $attachname);
        if (!$mail->send()) {
            $log = new Logger();
            $log->logErrorForPhpMailer($mail->ErrorInfo, 'Email');
            throw new \Exception(' Error occured while sending email to ' . $To, Values::$resCode_emailSendingError);
        } else {
            return '1';
        }
    }

}
