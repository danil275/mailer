<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Email;
use App\Domain\Repository\EmailRepositoryInterface;

class EmailRepository extends AbstractRepository implements EmailRepositoryInterface
{

    public function find(int $id): ?Email
    {
        return $this->repository->find($id);
    }

    public function findByHash(string $hash): ?Email
    {
        return $this->repository->findOneBy(['hash' => $hash]);
    }

    public function save(Email $email): void
    {
        $this->em->persist($email);
        $this->em->flush();
    }

    protected function getClass(): string
    {
        return Email::class;
    }
}
