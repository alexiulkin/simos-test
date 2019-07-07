<?php

namespace Application\Helper;

use Application\Exception\RuntimeException;
use ErrorException;

class Mail implements MailInterface
{
    const TO_EMAIL = "to@example.com";
    const FROM_EMAIL = "from@example.com";
    const REPLY_TO_EMAIL = "reply-to@example.com";
    const SUBJECT_EMAIL = "Форма обратной связи";

    /**
     * Отправить email
     *
     * @param string $message
     * @return bool
     */
    public function send(string $message): bool
    {
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });

        try {
            $headers = "Content-type: text/html; charset=windows-1251" . PHP_EOL;
            $headers .= "From: " . self::FROM_EMAIL . PHP_EOL;
            $headers .= "Reply-To: " . self::REPLY_TO_EMAIL . PHP_EOL;

            return mail(self::TO_EMAIL, self::SUBJECT_EMAIL, $message, $headers);

        } catch (ErrorException $e) {
            return false;
        }
    }
}