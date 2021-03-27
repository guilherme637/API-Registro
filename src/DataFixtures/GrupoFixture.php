<?php

namespace App\DataFixtures;

use App\Entity\Grupo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GrupoFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $agua = new Grupo();
        $luz = new Grupo();
        $telefone = new Grupo();
        $internet = new Grupo();

        $agua->setTipo('agua');
        $luz->setTipo('luz');
        $telefone->setTipo('telefone');
        $internet->setTipo('internet');

        $manager->persist($agua);
        $manager->persist($luz);
        $manager->persist($telefone);
        $manager->persist($internet);
        $manager->flush();
    }
}
