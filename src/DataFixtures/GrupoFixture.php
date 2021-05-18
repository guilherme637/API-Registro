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
        $cartao = new Grupo();
        $consorcio = new Grupo();
        $planoDeSaude = new Grupo();
        $vigilacia = new Grupo();
        $seguro = new Grupo();
        $imposto = new Grupo();

        $agua->setTipo('agua');
        $luz->setTipo('luz');
        $telefone->setTipo('telefone');
        $internet->setTipo('internet');
        $cartao->setTipo('cartão');
        $consorcio->setTipo('consórcio');
        $planoDeSaude->setTipo('plano de saúde');
        $vigilacia->setTipo('vigilância');
        $seguro->setTipo('seguro');
        $imposto->setTipo('imposto');

        $manager->persist($agua);
        $manager->persist($luz);
        $manager->persist($telefone);
        $manager->persist($internet);
        $manager->persist($cartao);
        $manager->persist($consorcio);
        $manager->persist($planoDeSaude);
        $manager->persist($vigilacia);
        $manager->persist($seguro);
        $manager->persist($imposto);
        $manager->flush();
    }
}
