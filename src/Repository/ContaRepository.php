<?php

namespace App\Repository;

use App\Entity\Conta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function save($entity): ?array
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

        return null;
    }

    public function update(): ?array
    {
        $this->getEntityManager()->beginTransaction();
        try {
            $this->getEntityManager()->flush();
            $this->getEntityManager()->commit();
        } catch (\Exception $ex) {
            $this->getEntityManager()->rollback();
            return $ex->getTrace();
        }

        return null;
    }

    public function valueTotal()
    {
        $velueTotal = $this->getEntityManager()
            ->createQuery('SELECT c.valor from App\Entity\Conta c')
            ->getResult();

        return array_sum(array_column($velueTotal, 'valor'));
    }

    public function onlyDateFeedBack()
    {
        $dates = $this->getEntityManager()
            ->createQuery('SELECT c.dataFeedBack FROM App\Entity\Conta c')
            ->getResult();

        return array_values(array_column($dates, 'dataFeedBack'));
    }

    public function findAllGrupos(int $id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT IDENTITY(c.grupo) as grupo_id, c.nome, c.valor, c.dataFeedBack, f.id FROM App\Entity\Conta c 
                 INNER JOIN App\Entity\Grupo gp WITH c.grupo = gp.id
                 INNER JOIN App\Entity\Financa f WITH c.financa = f.id
                 WHERE f.id = :id'
            )
            ->setParameter('id', $id)
            ->getResult()
        ;
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
