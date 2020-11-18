<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const TOTO_USER_REFERENCE = 'toto';

    private $encoder;

    //On applique un service d'encodage de mot de passe par une injection de dépendances normales
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('toto@toto.com');
        $user->setRoles(['ROLE_USER']);
        $password = $this->encoder->encodePassword($user, 'Lola2013!');
        $user->setPassword($password);
        $user->setLastname('royce');
        $user->setFirstname('toto');
        $user->setCity('rouen');
        $user->setCityCode('76350');
        $user->setAdress('afpa');
        $user->setSex('M');
        $user->setBirthdate(new \DateTime('1986-09-19'));
        $user->setIsVerified(TRUE);
        $manager->persist($user);
        $manager->flush();

        // other fixtures can get this object using the UserFixtures::ADMIN_USER_REFERENCE constant
        $this->addReference(self::TOTO_USER_REFERENCE, $user);
    }
}
