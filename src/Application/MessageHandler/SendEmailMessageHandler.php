<?php

declare(strict_types=1);

namespace App\Application\MessageHandler;

use App\Application\Message\SendEmailMessage;
use App\Domain\Entity\EmailStatus;
use App\Domain\Repository\EmailStatusRepositoryInterface;
use App\Domain\Service\EmailSenderInterface;
use App\Infrastructure\Repository\EmailRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Cache\CacheInterface;

#[AsMessageHandler]
class SendEmailMessageHandler
{
    public function __construct(
        private readonly EmailRepository                $emailRepository,
        private readonly EmailSenderInterface           $emailSender,
        private readonly EmailStatusRepositoryInterface $emailStatusRepository,
        private LoggerInterface                         $logger,
        private readonly CacheInterface                 $cache,
    )
    {
    }

    public function __invoke(SendEmailMessage $message): void
    {
        $email = $this->emailRepository->find($message->emailId);

        if ($email === null) {
            return;
        }

        try {
            $this->emailSender->send($email);
            $sentStatus = $this->emailStatusRepository->find(EmailStatus::STATUS_SENT);
            $email->setStatus($sentStatus);

        } catch (\Throwable $e) {
            $failedStatus = $this->emailStatusRepository->find(EmailStatus::STATUS_FAILED);
            $email->setStatus($failedStatus);
            $this->logger->error($e->getMessage());
        } finally {
            $this->emailRepository->save($email);
        }
    }
}
