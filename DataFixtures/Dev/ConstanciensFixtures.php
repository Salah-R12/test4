<?php

// src/DataFixtures/Dev/ConstanciensFixtures.php

namespace App\DataFixtures\Dev;

use App\Entity\Constanciens;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class ConstanciensFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $constancien = new Constanciens();
            $constancien->setFirstname($faker->firstName);
            $constancien->setNamePatronymic($faker->lastName);
            $constancien->setNameMarital($faker->lastName);
            $constancien->setGender($faker->numberBetween(0, 1));
            $constancien->setBirthPlace($faker->city);
            $constancien->setBirthDate($faker->dateTimeThisCentury->getTimestamp());
            $constancien->setInvitationMonth($faker->dateTimeThisYear);

            // Assigning references to RefCes, RefCpam, and RefSite entities
            $constancien->setCES($this->getReference('ref_ces_' . rand(0, 1)));
            $constancien->setCPAM($this->getReference('ref_cpam_' . rand(0, 1)));
            $constancien->setCESPlace($this->getReference('ref_site_' . rand(0, 1)));

            $constancien->setAddressComplement($faker->secondaryAddress);
            $constancien->setAddressComplement2($faker->secondaryAddress);
            $constancien->setAddressNum($faker->buildingNumber);
            $constancien->setPostDeliver($faker->postcode);
            $constancien->setPostcode($faker->postcode);
            $constancien->setCity($faker->city);
            $constancien->setCountry($faker->country);
            $constancien->setExcluded($faker->numberBetween(0, 1));
            $constancien->setVolunteer($faker->numberBetween(0, 1));
            $constancien->setValidatedFiche($faker->numberBetween(0, 1));
            $constancien->setBirthDep($faker->departmentNumber);
            $constancien->setPointRemise($faker->streetName);
            $constancien->setAdresseMention($faker->sentence);
            $constancien->setCodeCaisseGes($faker->randomNumber(4));
            $constancien->setCodeCentrePaie($faker->randomNumber(4));
            $constancien->setCodeRegime($faker->randomNumber(2));
            $constancien->setClass($faker->randomNumber(1));
            $constancien->setAddressUpdated($faker->dateTimeThisYear->getTimestamp());
            $constancien->setUpdated($faker->dateTimeThisYear->getTimestamp());
            $constancien->setUpdatedPnd($faker->dateTimeThisYear->getTimestamp());
            $constancien->setCreated($faker->dateTimeThisYear->getTimestamp());
            $constancien->setInvitationRank($faker->numberBetween(1, 10));
            $constancien->setCellphone(substr($faker->phoneNumber, 0, 10));
            $constancien->setReinvite($faker->numberBetween(0, 1));

            $manager->persist($constancien);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RefCesFixtures::class,
            RefSiteFixtures::class,
            RefCpamFixtures::class,
        ];
    }
}
