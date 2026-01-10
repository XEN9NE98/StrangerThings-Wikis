<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function sendEmail($to, $subject, $body, $isHtml = false)
{
    try {
        $mail = new PHPMailer(true);

        // Gmail SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'strangerthingswikii@gmail.com';   // your website Gmail
        $mail->Password   = 'ipwfghtyuhztzbda';                 // 16-char App Password (NO spaces)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender
        $mail->setFrom('strangerthingswikii@gmail.com', 'Stranger Things Wiki');
        $mail->addAddress($to);

        // Email format
        if ($isHtml) {
            $mail->isHTML(true);
        }

        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Email Error: " . $mail->ErrorInfo);
        return false;
    }
}
