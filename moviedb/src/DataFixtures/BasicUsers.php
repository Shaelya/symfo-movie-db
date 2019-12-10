<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BasicUsers extends Fixture
{

    // Comme nous ne sommes pas dans un Contrôleur mais dans une Fixture, on doit injecter l'encoder dans cette classe, on créé donc une méthode construct pour associer l'objet encoder à notre propriété
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setEmail('admin@t.oc');
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $encodedPwd = $this->encoder->encodePassword($userAdmin, 'admin');
        $userAdmin->setPassword($encodedPwd);
        $manager->persist($userAdmin);

        $userUser = new User();
        $userUser->setEmail('user@t.oc');
        $userUser->setRoles(['ROLE_USER']);
        $encodedPwd = $this->encoder->encodePassword($userUser, 'user');
        $userUser->setPassword($encodedPwd);
        $manager->persist($userUser);

        $manager->flush();
    }
}
