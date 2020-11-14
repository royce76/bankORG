<?php

namespace App\DataFixtures;

use App\Entity\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AccountFixtures extends Fixture implements DependentFixtureInterface
{
    public const TOTO_ACCOUNT_REFERENCE = ['1','2','3'];

    public function load(ObjectManager $manager)
    {
        foreach (self::TOTO_ACCOUNT_REFERENCE as $value) {
          $account = new Account();
          $account->setAccountType('Compte courant n° '. $value);
          $account->setOpeningDate(new \DateTime);
          $account->setBalance(100);
          //On récupère la référence dans l'entité user pour lié les deux fixtures entre elles
          $account->setUser($this->getReference(UserFixtures::TOTO_USER_REFERENCE));
          // other fixtures can get this object using the UserFixtures::ADMIN_USER_REFERENCE constant
          $this->addReference($value, $account);
          $manager->persist($account);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
