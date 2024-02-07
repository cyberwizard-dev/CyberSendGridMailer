# Cyberwizard SendGrid Mailer

Cyberwizard SendGrid Mailer is a Laravel package designed to simplify the process of sending emails using SendGrid API
KEY and Laravel Blade templates. This package is useful when you need to send emails with dynamic content generated from
Blade templates while leveraging the power of SendGrid for email delivery.

## Why Cyberwizard SendGrid Mailer?

When integrating SendGrid with Laravel applications, you might want to utilize Blade templates for email content
generation. However, using Blade templates directly with SendGrid API can be challenging due to compatibility issues.
Cyberwizard SendGrid Mailer solves this problem by providing a seamless integration between Laravel Blade templates and
SendGrid API.

## Installation

You can install the package via Composer:

```bash
composer require cyberwizard/sendgrid-mailer
```

## Usage

Once installed, you can use the `sendEmail` method provided by the `Cyberwizard\SendGridMailer\CyberSendGridMailer`
class to send emails. Here's how you can use it:

```php
use Cyberwizard\SendGridMailer\CyberSendGridMailer;

$subject = 'Your email subject';
$to = 'recipient@example.com';
$fromEmail = 'sender@example.com';
$fromName = 'Sender Name';
$templatePath = 'emails.template'; // Path to your Blade template
$data = [
    'name' => 'John Doe',
    'order_id' => '123456',
    // Add more key-value pairs as needed
];

try {
    $success = CyberSendGridMailer::sendEmail($subject, $to, $fromEmail, $fromName, $templatePath, $data);
    if ($success) {
        // Email sent successfully
    } else {
        // Email sending failed
    }
} catch (\Exception $e) {
    // Handle exception
}
```

## Environment Configuration

Before using the package, make sure to set your SendGrid API key in your `.env` file:

```
SENDGRID_API_KEY=your-sendgrid-api-key
```

## Parameters

- `$subject` (string): The subject of the email.
- `$to` (string): The recipient email address.
- `$fromEmail` (string): The sender's email address.
- `$fromName` (string, optional): The sender's name.
- `$templatePath` (string): The path to the email template in your views directory. For example: `'emails.template'`.
- `$data` (array, optional): The data to pass to the email template. For example:
  ```php
  [
      'name' => 'John Doe',
      'order_id' => '123456',
      // Add more key-value pairs as needed
  ]
  ```

## License

This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).