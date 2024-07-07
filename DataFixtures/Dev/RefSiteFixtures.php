<?php
// src/DataFixtures/Dev/refSiteFixtures.php

namespace App\DataFixtures\Dev;

use App\Entity\refSite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RefSiteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $siteList = [
            [
                'refCesIndex' => 0,
                'title' => 'Site Title 1',
                'fieldNameValue' => 'Site Full Name 1',
                'fieldAddressValue' => '789 Tertiary St',
                'fieldCedexValue' => 'Cedex 3',
                'fieldPostcodeValue' => '75003',
                'fieldCityValue' => 'Marseille',
                'fieldPoBoxValue' => 'PO Box 789',
                'fieldPhoneValue' => '0234567890',
                'fieldFaxValue' => '0234567890',
                'fieldNbMaxRdvValue' => 8,
                'fieldPastConvocValue' => 1
            ],
            [
                'refCesIndex' => 1,
                'title' => 'Site Title 2',
                'fieldNameValue' => 'Site Full Name 2',
                'fieldAddressValue' => '101112 Quaternary St',
                'fieldCedexValue' => 'Cedex 4',
                'fieldPostcodeValue' => '75004',
                'fieldCityValue' => 'Nice',
                'fieldPoBoxValue' => 'PO Box 101112',
                'fieldPhoneValue' => '0345678901',
                'fieldFaxValue' => '0345678901',
                'fieldNbMaxRdvValue' => 15,
                'fieldPastConvocValue' => 0
            ]
        ];

        foreach ($siteList as $index => $siteData) {
            $refSite = new refSite();
            $refSite->setRefCes($this->getReference('ref_ces_' . $siteData['refCesIndex']));
            $refSite->setTitle($siteData['title']);
            $refSite->setFieldNameValue($siteData['fieldNameValue']);
            $refSite->setFieldAddressValue($siteData['fieldAddressValue']);
            $refSite->setFieldCedexValue($siteData['fieldCedexValue']);
            $refSite->setFieldPostcodeValue($siteData['fieldPostcodeValue']);
            $refSite->setFieldCityValue($siteData['fieldCityValue']);
            $refSite->setFieldPoBoxValue($siteData['fieldPoBoxValue']);
            $refSite->setFieldPhoneValue($siteData['fieldPhoneValue']);
            $refSite->setFieldFaxValue($siteData['fieldFaxValue']);
            $refSite->setFieldNbMaxRdvValue($siteData['fieldNbMaxRdvValue']);
            $refSite->setFieldPastConvocValue($siteData['fieldPastConvocValue']);

            $manager->persist($refSite);

            // Stockez la référence pour l'utiliser si nécessaire dans d'autres fixtures
            $this->addReference('ref_site_' . $index, $refSite);
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
