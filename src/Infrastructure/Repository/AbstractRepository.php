<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository
{

    protected readonly EntityRepository $repository;

    public function __construct(protected readonly EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository($this->getClass());
    }

    protected abstract function getClass(): string;
}
