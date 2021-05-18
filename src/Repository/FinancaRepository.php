<?php

namespace App\Repository;

use App\Entity\Financa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Financa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Financa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Financa[]    findAll()
 * @method Financa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinancaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Financa::class);
    }

    public function billsByFinance()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT c.nome,  c.valor, c.data, f.id FROM App\Entity\Financa f
                 INNER JOIN App\Entity\Conta c WITH c.financa = f.id'
            )
            ->getResult();
    }
}