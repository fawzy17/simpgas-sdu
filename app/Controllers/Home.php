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

    public function send_email()
    {
        $to                 = $this->request->getPost('to');
        $subject            = $this->request->getPost('subject');
        $message            = $this->request->getPost('message');

        $mail = new PHPMailer(true);
        
        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->isHTML();
            $mail->Host       = 'smtp.googlemail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'rayrizkyfawzy@gmail.com'; // ubah dengan alamat email Anda
            $mail->Password   = 'kbgi evwq rdyx tnec'; // ubah dengan app password email Anda
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('rayrizkyfawzy@gmail.com', 'Ray Rizky Fawzy'); // ubah dengan alamat email Anda
            $mail->addAddress($to);
            $mail->addReplyTo('rayrizkyfawzy@gmail.com', 'Ray Rizky Fawzy'); // ubah dengan alamat email Anda

            // Isi Email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = '<h1>Hello!</h1><p>This is an' . $message . 'HTML email.</p>';
            $mail->send();

            return redirect()->to(base_url('/dashboard'))->with('success_message', 'Berhasil mengirim email');
        } catch (Exception $e) {
            return redirect()->to(base_url('/dashboard'))->with('error_message', 'Gagal mengirim email');
        }
    }
}
