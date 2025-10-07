<?php

namespace App\Repository;

use App\Entity\Token;
use App\Entity\User;
use App\Traits\Repository\RepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Token>
 */
class TokenRepository extends ServiceEntityRepository
{
    use RepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Token::class);
    }

    public function countUserToken(User $user, string $name): int
    {
        return (int) $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->andWhere('t.owner = :user')
            ->andWhere('t.name = :name')
            ->setParameter('user', $user)
            ->setParameter('name', $name)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
