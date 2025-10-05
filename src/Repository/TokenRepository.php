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

    public function countUserToken(User $user, string $key): int
    {
        return $this->createQueryBuilder('COUNT(t)')
            ->andWhere('t.user = :user')
            ->andWhere('t.key = :key')
            ->setParameter('user', $user)
            ->setParameter('key', $key)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
