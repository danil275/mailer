<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Email;

interface EmailRepositoryInterface
{
    public function find(int $id): ?Email;

    public function findByHash(string $hash): ?Email;

    public function save(Email $email): void;
}
