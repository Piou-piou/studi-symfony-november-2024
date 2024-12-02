<?php

namespace App\DataFixtures\User;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

abstract class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function createUser(ObjectManager $manager, string $username, null|string|array $roles, $password = 'test'): User
    {
        if (null !== $roles && !is_array($roles)) {
            $roles = [$roles];
        }

        [$firstname, $lastname] = explode('.', $username);

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $user->setFirstname($firstname);
        $user->setLastname($lastname);

        if (null !== $roles) {
            $user->setRoles($roles);
        }

        return $user;
    }
}