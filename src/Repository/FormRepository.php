<?php

namespace App\Repository;

use App\Component\MandateGet;
use App\Entity\Form;
use App\Entity\Mandate;
use App\Entity\User;
use App\Model\List\Result;
use App\Traits\Repository\RepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Form>
 */
class FormRepository extends ServiceEntityRepository
{
    use RepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Form::class);
    }

    public function getList(Mandate|User $mandate): Result
    {
        $mandate = MandateGet::get($mandate);

        $qb = $this->createQueryBuilder('f')
            ->join('f.draftVersion', 'dfv')
            ->leftJoin('f.publishedVersion', 'pfv')
            ->andWhere('f.mandate = :mandate')
            ->setParameter('mandate', $mandate)
        ;

        $total = (int) $qb->select('COUNT(f.id)')
            ->getQuery()
            ->getSingleScalarResult();

        if ($total === 0) {
            return new Result([], 0);
        }

        $result = $qb->select('f')
            ->orderBy('dfv.updated', 'DESC')
            ->setMaxResults(self::MAX_RESULTS)
            ->getQuery()
            ->getResult();

        return new Result($result, $total);
    }
}
