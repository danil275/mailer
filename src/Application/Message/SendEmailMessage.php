<?php

declare(strict_types=1);

namespace App\Application\Message;

class SendEmailMessage
{
    public function __construct(
        public readonly int $emailId,
    )
    {
    }
}
