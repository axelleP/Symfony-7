<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $factory = new PasswordHasherFactory(['common' => ['algorithm' => 'bcrypt']]);
        $hasher = $factory->getPasswordHasher('common');
        $hash = $hasher->hash('password');

        $faker = Factory::create();

        $user = new User();
        $user->setRole('guest');
        $user->setUsername($faker->userName());
        $user->setEmail($faker->unique()->safeEmail());
        $user->setPassword($hash);
        $manager->persist($user);

        $manager->flush();
    }
}
