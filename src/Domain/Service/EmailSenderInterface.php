<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Email;

interface EmailSenderInterface
{
    public function send(Email $email): void;
}
