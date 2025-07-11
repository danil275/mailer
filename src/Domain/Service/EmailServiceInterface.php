<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\Email;
use App\Domain\Entity\EmailStatus;

interface EmailServiceInterface
{
    public function send(Email $email): Email;

    public function status(int $emailId): EmailStatus;
}
