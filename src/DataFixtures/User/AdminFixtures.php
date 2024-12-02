<?php

namespace App\DataFixtures\User;

use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends UserFixtures
{
    public function load(ObjectManager $manager)
    {
        $admin1 = $this->createUser($manager, 'u.admin', 'ROLE_ADMIN');
        $admin1->setFirstname('Anthony');

        $manager->persist($admin1);

        $admin2 = $this->createUser($manager, 'u1.admin', 'ROLE_ADMIN');
        $manager->persist($admin2);

        $manager->flush();
    }
}