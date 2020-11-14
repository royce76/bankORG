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
        foreach (AccountFixtures::TOTO_ACCOUNT_REFERENCE as $value) {
          for ($i=0; $i < 2; $i++) {
            $operation = new Operation();
            $operation->setOperationType('Opération n° '. $i);
            $operation->setAmount(20);
            $operation->setComments('Justificatif n°' . $i);
            $operation->setDateTransaction(new \DateTime);

            //On récupère la référence dans l'entité user pour lié les deux fixtures entre elles
            $operation->setUser($this->getReference(UserFixtures::TOTO_USER_REFERENCE));
            $operation->setAccount($this->getReference($value));
            $manager->persist($operation);
          }
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
