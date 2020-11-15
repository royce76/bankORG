<?php

namespace App\Repository;

use App\Entity\Operation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Operation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operation[]    findAll()
 * @method Operation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operation::class);
    }

    //fonction appelé à homepage
    /**
     * @return Operation[]
     */
    public function getAccountLastOperation($user_id):array
    {
      $qb = $this->createQueryBuilder('o')
          ->where('o.user = :id')
          ->groupBy('o.account')
          ->orderBy('o.account', 'DESC')
          ->setParameter('id', $user_id);

      $query = $qb->getQuery();
      return $query->execute();
    }

    //fonction appelé avec le paramètre id du compte sélectionner à homepage
    /**
     * @return Operation[]
     */
    public function getAccountAndOperations($account_id):array
    {
      $qb = $this->createQueryBuilder('o')
          ->where('o.account = :id')
          ->orderBy('o.id', 'DESC')
          ->setParameter('id', $account_id);

      $query = $qb->getQuery();
      return $query->execute();
    }


}
