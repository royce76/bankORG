<?php

namespace App\DataFixtures;

use App\Entity\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AccountFixtures extends Fixture implements DependentFixtureInterface
{
    public const TOTO_ACCOUNT_REFERENCE = ['Compte courant', 'PEL', 'Compte jeune'];

    public function load(ObjectManager $manager)
    {
        foreach (self::TOTO_ACCOUNT_REFERENCE as $value) {
          $account = new Account();
          $account->setAccountType($value);
          $account->setOpeningDate(new \DateTime);
          if ($value === "Compte courant") {
            $account->setBalance(100);
          }
          elseif ($value === "PEL") {
            $account->setBalance(150);
          }
          else {
            $account->setBalance(50);
          }
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
