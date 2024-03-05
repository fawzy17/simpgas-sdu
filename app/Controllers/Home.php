<?php

namespace App\Controllers;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Home extends BaseController
{
    public function index(): string
    {
        helper(['form']);
        return view('index');
    }

    public function send_email($to, $subject, $message)
    {


        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->isHTML();
            $mail->Host       = 'smtp.googlemail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'bitcoinid86@gmail.com'; // ubah dengan alamat email Anda
            $mail->Password   = 'tqap vbnc gttf ldgu '; // ubah dengan app password email Anda
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('rayrizkyfawzy@gmail.com', 'Ray Rizky Fawzy'); // ubah dengan alamat email Anda
            $mail->addAddress($to);
            $mail->addReplyTo('rayrizkyfawzy@gmail.com', 'Ray Rizky Fawzy'); // ubah dengan alamat email Anda

            // Isi Email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->send();
            $response = [
                'success' => true,
                'message' => 'Email sent successfully.',
            ];

            
            return $response;
        } catch (Exception $e) {

            $response = [
                'success' => false,
                'message' => 'Email failed to send. Error: ' . $e,
            ];
            return $response;
        }
    }
}
