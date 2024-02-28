<?php

namespace Cyberwizard\SendGridMailer;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use SendGrid\Mail\Mail;

use SendGrid\Mail\TypeException;

class CyberSendGridMailer
{
    /**
     * Sends an email using SendGrid API KEY and Laravel Blade Template.
     *
     * @param string $subject The subject of the email.
     * @param string $to The recipient email address.
     * @param string $templatePath The path to the email template in your views dir. e.g 'templates.share-document-mail'
     * @param array $data The data to pass to the email template. For example:
     * [
     *     'name' => 'John Doe',
     *     'order_id' => '123456',
     *     // Add more key-value pairs as needed
     * ]
     * @return void True if the email was sent successfully, false otherwise.
     * @throws Exception If there is an unexpected error during email sending.
     */

    public static function sendEmail(string $subject, string $to, $fromEmail, string $templatePath, $content ="", array $data = [] )
    {
        $email = new Mail();
        $email->setFrom($fromEmail, env('APP_NAME'));
        $email->setSubject($subject);
        $email->addTo($to);

        if (empty($data)) {
            $email->addContent('text/plain', $content);
        } else {
            $mail = View::make($templatePath, $data)->render();
            $email->addContent('text/html', $mail);
        }

        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));

        try {
            $response = $sendgrid->send($email);
            return $response;
            Log::info("SendGrid Email Sent - Status Code: {$response->statusCode()}, Headers: " . json_encode($response->headers()) . ", Body: {$response->body()}");
        } catch (Exception $e) {
            Log::error('Exception caught: ' . $e->getMessage());
            throw $e;
        }
    }

}
