<?php

declare(strict_types=1);

namespace App\Traits\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;

/**
 * @method EntityManagerInterface getEntityManager()
 */
trait RepositoryTrait
{
    public function assertResult(object|null $result): void
    {
        if (is_null($result)) {
            throw new NoResultException();
        }
    }

    public function persist(object|array $entity, bool $flush = true): void
    {
        $entities = is_object($entity) ? [$entity] : $entity;
        foreach ($entities as $item) {
            $this->getEntityManager()->persist($item);
        }

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function em(): EntityManagerInterface
    {
        return $this->getEntityManager();
    }
}
