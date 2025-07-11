<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Entity\Email;
use App\Domain\Service\EmailSenderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as SymfonyEmail;

class EmailSender implements EmailSenderInterface
{

    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function send(Email $email): void
    {
        $symfonyEmail = (new SymfonyEmail())
            ->from($email->getFrom())
            ->to($email->getTo())
            ->subject($email->getSubject())
            ->text($email->getBody());

        $this->mailer->send($symfonyEmail);
    }
}
