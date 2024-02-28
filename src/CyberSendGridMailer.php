<?php

namespace Cyberwizard\SendGridMailer;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use SendGrid\Mail\TypeException;

class CyberSendGridMailer
{
    /**
     * Sends an email using SendGrid API KEY and Laravel Blade Template.
     *
     * @param string $subject The subject of the email.
     * @param string $to The recipient email address.
     * @param string $fromEmail The sender's email address.
     * @param string $fromName The sender's name.
     * @param string $templatePath The path to the email template in your views dir. e.g 'templates.share-document-mail'
     * @param array $data The data to pass to the email template. For example:
     * [
     *     'name' => 'John Doe',
     *     'order_id' => '123456',
     *     // Add more key-value pairs as needed
     * ]
     * @return bool True if the email was sent successfully, false otherwise.
     * @throws TypeException If there is an issue with the email content type.
     * @throws Exception If there is an unexpected error during email sending.
     */
    public static function sendEmail(string $subject, string $fromEmail, string $to, string $fromName = "", string $templatePath, array $data = []): bool
    {
        $email = new Mail();
        $email->setFrom($fromEmail, $fromName ?? env('APP_NAME'));
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
