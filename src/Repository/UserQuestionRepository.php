<?php

namespace App\Repository;

use App\Entity\UserQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserQuestion[]    findAll()
 * @method UserQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserQuestion::class);
    }

    // /**
    //  * @return UserQuestion[] Returns an array of UserQuestion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserQuestion
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
