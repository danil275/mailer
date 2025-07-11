<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Message\SendEmailMessage;
use App\Domain\Entity\Email;
use App\Domain\Entity\EmailStatus;
use App\Domain\Exception\EmailIdNotFoundException;
use App\Domain\Exception\EmailIsAlreadySendException;
use App\Domain\Repository\EmailRepositoryInterface;
use App\Domain\Repository\EmailStatusRepositoryInterface;
use App\Domain\Service\EmailServiceInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class EmailService implements EmailServiceInterface
{

    public function __construct(
        private readonly EmailRepositoryInterface       $emailRepository,
        private readonly EmailStatusRepositoryInterface $emailStatusRepository,
        private readonly MessageBusInterface $messageBus,
    )
    {
    }

    /**
     * @throws EmailIsAlreadySendException
     */
    public function send(Email $email): Email
    {
        $emailStatusPending = $this->emailStatusRepository->find(EmailStatus::STATUS_PENDING);

        $hash = hash('xxh64',
            $email->getFrom() . $email->getTo() . $email->getBody() . $email->getSubject());

        $emilByHash = $this->emailRepository->findByHash($hash);
        if ($emilByHash !== null) {
            throw new EmailIsAlreadySendException();
        }

        $email->setStatus($emailStatusPending);
        $email->setHash($hash);
        $email->setCreatedAt(new \DateTime());

        $this->emailRepository->save($email);

        $this->messageBus->dispatch(new SendEmailMessage($email->getId()));

        return $email;
    }

    public function status(int $emailId): EmailStatus
    {
        $email = $this->emailRepository->find($emailId);
        if($email === null) {
            throw new EmailIdNotFoundException();
        }

        return $email->getStatus();
    }
}
