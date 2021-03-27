<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $hash = password_hash('gui123', PASSWORD_ARGON2ID);

        $user->setUsername('guilherme')
            ->setPassword($hash);

        $manager->persist($user);
        $manager->flush();
    }
}