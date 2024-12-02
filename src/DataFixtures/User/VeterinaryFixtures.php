<?php

namespace App\DataFixtures\User;

use Doctrine\Persistence\ObjectManager;

class VeterinaryFixtures extends UserFixtures
{
    public function load(ObjectManager $manager)
    {
        $vet1 = $this->createUser($manager, 'u.veterinary', 'ROLE_VETERINARY');
        $manager->persist($vet1);


        $vet2 = $this->createUser($manager, 'u1.veterinary', 'ROLE_VETERINARY');
        $manager->persist($vet2);
    }
}