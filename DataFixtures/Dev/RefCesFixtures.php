<?php
// src/DataFixtures/Dev/RefCesFixtures.php

namespace App\DataFixtures\Dev;

use App\Entity\RefCes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RefCesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $cesList = [
            [
                'title' => 'CES Title 1',
                'fieldNameValue' => 'CES Full Name 1',
                'fieldAddressValue' => '123 Main St',
                'fieldCedexValue' => 'Cedex 1',
                'fieldPostcodeValue' => '75001',
                'fieldCityValue' => 'Paris',
                'fieldPoBoxValue' => 'PO Box 123',
                'fieldPhoneValue' => '0123456789',
                'fieldFaxValue' => '0123456789',
                'fieldNbMaxRdvValue' => 10,
                'fieldPastConvocValue' => 0,
                'fieldDefaultSiteValue' => 1
            ],
            [
                'title' => 'CES Title 2',
                'fieldNameValue' => 'CES Full Name 2',
                'fieldAddressValue' => '456 Secondary St',
                'fieldCedexValue' => 'Cedex 2',
                'fieldPostcodeValue' => '75002',
                'fieldCityValue' => 'Lyon',
                'fieldPoBoxValue' => 'PO Box 456',
                'fieldPhoneValue' => '0987654321',
                'fieldFaxValue' => '0987654321',
                'fieldNbMaxRdvValue' => 5,
                'fieldPastConvocValue' => 1,
                'fieldDefaultSiteValue' => 2
            ]
        ];

        foreach ($cesList as $index => $cesData) {
            $refCes = new RefCes();
            $refCes->setTitle($cesData['title']);
            $refCes->setFieldNameValue($cesData['fieldNameValue']);
            $refCes->setFieldAddressValue($cesData['fieldAddressValue']);
            $refCes->setFieldCedexValue($cesData['fieldCedexValue']);
            $refCes->setFieldPostcodeValue($cesData['fieldPostcodeValue']);
            $refCes->setFieldCityValue($cesData['fieldCityValue']);
            $refCes->setFieldPoBoxValue($cesData['fieldPoBoxValue']);
            $refCes->setFieldPhoneValue($cesData['fieldPhoneValue']);
            $refCes->setFieldFaxValue($cesData['fieldFaxValue']);
            $refCes->setFieldNbMaxRdvValue($cesData['fieldNbMaxRdvValue']);
            $refCes->setFieldPastConvocValue($cesData['fieldPastConvocValue']);
            $refCes->setFieldDefaultSiteValue($cesData['fieldDefaultSiteValue']);

            $manager->persist($refCes);

            // Stockez la référence pour l'utiliser dans les fixtures de `RefCesSite`
            $this->addReference('ref_ces_' . $index, $refCes);
        }

        $manager->flush();
    }
}

