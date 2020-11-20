<?php

namespace App\Repository;

use App\Entity\Account;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }

    /**
     * @return Account[]
     */
    public function getAccounts($id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
          'SELECT a.id, a.balance, a.opening_date, a.account_type, o.operation_type, o.comments,o.date_transaction, o.amount
          FROM App\Entity\Account a
          LEFT JOIN App\Entity\Operation o
          WITH a.id = o.account
          WHERE a.user= :user_id AND (o.id = (
            SELECT MAX(o2.id)
            FROM App\Entity\Operation o2
            WHERE o2.account = a.id
          )OR o.id IS NULL)'
        )->setParameter('user_id', $id);

        // returns an array of Product objects
        return $query->getResult();
    }
}
