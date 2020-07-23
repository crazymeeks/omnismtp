<?php

namespace OmniSmtp\Exceptions;

class OmniMailException extends \Exception
{
    public static function smtpSenderException()
    {
        return new static("SMTP sender is required!");
    }

    public static function smtpRecipientsException()
    {
        return new static("SMTP recipients is required!");
    }

    public static function smtpIdentifierException()
    {
        return new static("SMTP identifier is required!");
    }

    public static function actualSendingEmailException(string $msg)
    {
        return new static($msg);
    }
}