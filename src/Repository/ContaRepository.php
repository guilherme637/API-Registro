<?php

namespace App\Repository;

use App\Entity\Conta;
use App\Service\ResponseJsonFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method Conta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conta[]    findAll()
 * @method Conta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conta::class);
    }

    public function save($entity)
    {
        $this->getEntityManager()->beginTransaction();
        try {
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->commit();
        } catch (\Exception $ex) {
            $this->getEntityManager()->rollback();
            return $ex->getTrace();
        }
    }

    public function update()
    {
        $this->getEntityManager()->beginTransaction();
        try {
            $this->getEntityManager()->flush();
            $this->getEntityManager()->commit();
        } catch (\Exception $ex) {
            $this->getEntityManager()->rollback();
            return $ex->getTrace();
        }
    }

    // /**
    //  * @return Conta[] Returns an array of Conta objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Conta
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
