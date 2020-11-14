<?php

namespace App\DataFixtures;

use App\Entity\Operation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\AccountFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OperationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 3 ; $i++) {
          $operation = new Operation();
          $operation->setOperationType('Opération n° '. $i);
          $operation->setAmount($i + 20);
          $operation->setComments('Justificatif n°' . $i);
          $operation->setDateTransaction(new \DateTime('2020-11-'.$i));

          //On récupère la référence dans l'entité user pour lié les deux fixtures entre elles
          $operation->setUser($this->getReference(UserFixtures::TOTO_USER_REFERENCE));
          $operation->setAccount($this->getReference(AccountFixtures::TOTO_ACCOUNT_REFERENCE));
          $manager->persist($operation);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            AccountFixtures::class,
        );
    }
}
