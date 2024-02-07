<?php

namespace Cyberwizard\SendGridMailer;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use SendGrid\Mail\TypeException;

class CyberSendGridMailer
{
    /**
     * @throws TypeException
     * @throws Exception
     */
    public static function sendEmail($subject, $to, $from, $templatePath, $data = []): bool
    {
        $email = new Mail();
        $email->setFrom($from, env('APP_NAME'));
        $email->setSubject($subject);
        $email->addTo($to);

        $content = View::make($templatePath, $data)->render();
        $email->addContent('text/html', $content);
        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));

        try {
            $response = $sendgrid->send($email);
            Log::info("SendGrid Email Sent - Status Code: {$response->statusCode()}, Headers: " . json_encode($response->headers()) . ", Body: {$response->body()}");
            return true; // Email sent successfully
        } catch (Exception $e) {
            Log::error('Exception caught: ' . $e->getMessage());
            return false; // Email sending failed
        }
    }
}
