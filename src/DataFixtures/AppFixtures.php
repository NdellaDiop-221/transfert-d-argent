<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $roleAdmin = new Role();
        $roleAdmin->setLibelle("admin");
        $manager->persist($roleAdmin);

        $roleSup_admin = new Role();
        $roleSup_admin->setLibelle("sup_admin");
        $manager->persist($roleSup_admin);

        $roleCaissier = new Role();
        $roleCaissier->setLibelle("caissier");
        $manager->persist($roleCaissier);

        $rolePartenaire = new Role();
        $rolePartenaire->setLibelle("partenaire");
        $manager->persist($rolePartenaire);


        $Admin = new User();
        $Admin->setFirstname("Abdou");
        $Admin->setLastname("Diop");
        $Admin->setUsername("karim");
        $Admin->setEmail("karim@gmail.com");
        $Admin->setPassword($this->encoder->encodePassword($Admin, "rimka2007"));
        $Admin->setRole($roleAdmin);
        $manager->persist($Admin);

        $Sup_admin = new User();
        $Sup_admin->setFirstname("Amy");
        $Sup_admin->setLastname("Diop");
        $Sup_admin->setUsername("myajop");
        $Sup_admin->setEmail("jopmya@gmail.com");
        $Sup_admin->setPassword($this->encoder->encodePassword($Sup_admin, "mya45"));
        $Sup_admin->setRole($roleSup_admin);
        $manager->persist($Sup_admin);

        $Caissier = new User();
        $Caissier->setFirstname("Issa");
        $Caissier->setLastname("Diop");
        $Caissier->setUsername("bsms");
        $Caissier->setEmail("isb@gmail.com");
        $Caissier->setPassword($this->encoder->encodePassword($Caissier, "bsms94"));
        $Caissier->setRole($roleCaissier);
        $manager->persist($Caissier);











        $manager->flush();
    }
}
