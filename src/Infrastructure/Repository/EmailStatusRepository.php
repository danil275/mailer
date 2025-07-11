<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\EmailStatus;
use App\Domain\Repository\EmailStatusRepositoryInterface;

class EmailStatusRepository extends AbstractRepository implements EmailStatusRepositoryInterface
{

    public function find(int $id): EmailStatus
    {
        return $this->repository->find($id);
    }

    protected function getClass(): string
    {
        return EmailStatus::class;
    }

}
