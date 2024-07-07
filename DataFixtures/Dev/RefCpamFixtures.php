<?php

// src/DataFixtures/Dev/RefCpamFixtures.php

namespace App\DataFixtures\Dev;

use App\Entity\RefCpam;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RefCpamFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cpamList = [
            [
                'title' => 'CPAM Title 1',
                'refCes' => 'ref_ces_0' // Référence à un RefCes existant
            ],
            [
                'title' => 'CPAM Title 2',
                'refCes' => 'ref_ces_1' // Référence à un RefCes existant
            ],
        ];

        foreach ($cpamList as $index => $cpamData) {
            $refCpam = new RefCpam();
            $refCpam->setTitle($cpamData['title']);
            $refCpam->setRefCes($this->getReference($cpamData['refCes']));

            $manager->persist($refCpam);

            // Stockez la référence pour l'utiliser dans les fixtures de `Constanciens`
            $this->addReference('ref_cpam_' . $index, $refCpam);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RefCesFixtures::class,
        ];
    }
}
