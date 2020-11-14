<?php

namespace App\DataFixtures;

use App\Entity\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AccountFixtures extends Fixture implements DependentFixtureInterface
{
    public const TOTO_ACCOUNT_REFERENCE = 'toto_account';

    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 3 ; $i++) {
          $account = new Account();
          $account->setAccountType('Compte courant n° '. $i);
          $account->setOpeningDate(new \DateTime);
          $account->setBalance($i + 100);
          //On récupère la référence dans l'entité user pour lié les deux fixtures entre elles
          $account->setUser($this->getReference(UserFixtures::TOTO_USER_REFERENCE));
          $manager->persist($account);
        }

        $manager->flush();

        // other fixtures can get this object using the UserFixtures::ADMIN_USER_REFERENCE constant
        $this->addReference(self::TOTO_ACCOUNT_REFERENCE, $account);

    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
