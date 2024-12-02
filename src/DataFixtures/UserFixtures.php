<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {

    }

    public function load(ObjectManager $manager)
    {
        $users = [
            'u.admin' => 'ROLE_ADMIN',
            'u.user' => 'ROLE_USER',
            'u.veterinary' => 'ROLE_VETERINARY',
            'u.visitor' => null,
        ];

        foreach ($users as $username => $role) {
            [$firstname, $lastname] = explode('.', $username);

            $user = new User();
            $user->setUsername($username);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'test'));
            $user->setFirstname($firstname);
            $user->setLastname($lastname);

            if (null !== $role) {
                $user->setRoles([$role]);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}