<?php

namespace App\Controllers;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Home extends BaseController
{
    protected $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mail->isSMTP();
        $this->mail->isHTML();
        $this->mail->Host       = 'smtp.googlemail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = 'bitcoinid86@gmail.com'; // ubah dengan alamat email Anda
        $this->mail->Password   = 'tqap vbnc gttf ldgu '; // ubah dengan app password email Anda
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->Port       = 465;
    }

    public function index(): string
    {
        helper(['form']);
        return view('index');
    }

    public function send_email($to, $subject, $message)
    {
        try {
            $this->mail->setFrom('rayrizkyfawzy@gmail.com', 'Ray Rizky Fawzy'); // ubah dengan alamat email Anda
            $this->mail->addAddress($to);
            $this->mail->addReplyTo('rayrizkyfawzy@gmail.com', 'Ray Rizky Fawzy'); // ubah dengan alamat email Anda

            // Isi Email
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $message;
            $this->mail->send();

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

    public function set_new_password(){

    }
}