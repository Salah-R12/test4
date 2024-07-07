<?php

namespace App\DataFixtures;

use App\DataFixtures\Dev\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            /* \App\DataFixtures\Dev\TrackingFixtures::class,
             \App\DataFixtures\Dev\ConstanciersEpsFixtures::class,
             \App\DataFixtures\Dev\PrintDemandConstancesFixtures::class,
             \App\DataFixtures\Dev\LettersFixtures::class,*/
            // Ajouter d'autres fixtures si nécessaire
        ];
    }

    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        // Vous pouvez également ajouter des chargements de données spécifiques ici si nécessaire
    }
}