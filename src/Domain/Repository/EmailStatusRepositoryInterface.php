<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\EmailStatus;

interface EmailStatusRepositoryInterface
{
    public function find(int $id): EmailStatus;
}
