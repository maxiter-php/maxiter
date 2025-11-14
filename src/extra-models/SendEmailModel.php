<?php
/*
This model works with PHPMailer to send emails.
Install using composer require phpmailer/phpmailer

@author Victor Béser
*/
use PHPMailer\PHPMailer\PHPMailer;
class SendEmailModel
{

    public static function send($to, $subject, $message)
    {
        // Your code here

        $mail = new PHPMailer();

        // EMAIL 
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = EnvModel::env("EMAIL_HOST");
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = EnvModel::env("EMAIL_LOGIN");
        $mail->Password = EnvModel::env("EMAIL_PASSWORD");
        $mail->setFrom(EnvModel::env("EMAIL_LOGIN"), EnvModel::env("EMAIL_NAME"));
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $message;
        try {
            $mail->send();
        } catch(Exception $e) {
            // LogModel::log("Err: $e");
        }
        // LogModel::log("Sent");
        // EMAIL

    }

}