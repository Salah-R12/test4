<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConstanciensRepository;

#[ORM\Entity(repositoryClass: ConstanciensRepository::class)]
#[ORM\Table(name: 'constanciens', options: ['comment' => 'Table des volontaires'])]
class Constanciens
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name: 'constancien_id', options: ['comment' => 'Numero Constance'])]
    private ?int $constancienId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'firstname', options: ['comment' => 'Prénom'])]
    private ?string $firstname = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'name_patronymic', options: ['comment' => 'Nom Patronymique'])]
    private ?string $namePatronymic = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'name_marital', options: ['comment' => 'Nom Marital'])]
    private ?string $nameMarital = null;

    #[ORM\Column(type: 'integer', nullable: true, name: 'gender', options: ['comment' => 'Genre'])]
    private ?int $gender = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'birth_place', options: ['comment' => 'Lieu de naissance'])]
    private ?string $birthPlace = null;

    #[ORM\Column(type: 'integer', nullable: true, name: 'birth_date', options: ['comment' => 'Date de naissance'])]
    private ?int $birthDate = null;

    #[ORM\Column(type: 'datetime', nullable: true, name: 'invitation_month', options: ['comment' => 'Mois d\'invitation'])]
    private ?\DateTimeInterface $invitationMonth = null;

    #[ORM\ManyToOne(targetEntity: RefCes::class, inversedBy: 'constanciens')]
    #[ORM\JoinColumn(name: 'CES', referencedColumnName: 'ces_id', nullable: false, options: ['comment' => 'CES'])]
    private ?RefCes $CES = null;

    #[ORM\ManyToOne(targetEntity: RefCpam::class, inversedBy: 'constanciens')]
    #[ORM\JoinColumn(name: 'CPAM', referencedColumnName: 'cpam_id', nullable: true, options: ['comment' => 'CPAM'])]
    private ?RefCpam $CPAM = null;

    #[ORM\ManyToOne(targetEntity: RefSite::class)]
    #[ORM\JoinColumn(name: 'CES_place', referencedColumnName: 'site_id', nullable: true, options: ['comment' => 'Site du CES'])]
    private ?RefSite $CESPlace = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'address_complement', options: ['comment' => 'Complement d\'adresse'])]
    private ?string $addressComplement = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'address_complement2', options: ['comment' => 'Complement d\'adresse'])]
    private ?string $addressComplement2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'address_num', options: ['comment' => 'Numéro'])]
    private ?string $addressNum = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'post_deliver', options: ['comment' => 'Bureau distributeur'])]
    private ?string $postDeliver = null;

    #[ORM\Column(type: 'string', length: 5, nullable: true, name: 'postcode', options: ['comment' => 'Bureau distributeur code postal'])]
    private ?string $postcode = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'city', options: ['comment' => 'Ville'])]
    private ?string $city = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'country', options: ['comment' => 'Pays'])]
    private ?string $country = null;

    #[ORM\Column(type: 'smallint', name: 'excluded', options: ['comment' => 'Exclus du CES'])]
    private int $excluded = 0;

    #[ORM\Column(type: 'smallint', name: 'volunteer', options: ['comment' => 'Est un volontaire'])]
    private int $volunteer = 0;

    #[ORM\Column(type: 'smallint', name: 'validated_fiche', options: ['comment' => 'La fiche a été validée'])]
    private int $validatedFiche = 0;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'birth_dep', options: ['comment' => 'Departement de naissance'])]
    private ?string $birthDep = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'point_remise', options: ['comment' => 'Point de remise'])]
    private ?string $pointRemise = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'adresse_mention', options: ['comment' => 'Mention adresse'])]
    private ?string $adresseMention = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'code_caisse_ges', options: ['comment' => 'Code caisse gestion'])]
    private ?string $codeCaisseGes = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'code_centre_paie', options: ['comment' => 'Code centre paiement'])]
    private ?string $codeCentrePaie = null;

    #[ORM\Column(type: 'string', length: 2, nullable: true, name: 'code_regime', options: ['comment' => 'Code Régime'])]
    private ?string $codeRegime = null;

    #[ORM\Column(type: 'integer', nullable: true, name: 'class', options: ['comment' => 'Classe'])]
    private ?int $class = null;

    #[ORM\Column(type: 'integer', nullable: true, name: 'address_updated', options: ['comment' => 'Mise à jour de l\'adresse'])]
    private ?int $addressUpdated = null;

    #[ORM\Column(type: 'integer', nullable: true, name: 'updated')]
    private ?int $updated = null;

    #[ORM\Column(type: 'integer', nullable: true, name: 'updated_pnd', options: ['comment' => 'Date mise à jour PND'])]
    private ?int $updatedPnd = null;

    #[ORM\Column(type: 'integer', nullable: true, name: 'created', options: ['comment' => 'Date de création'])]
    private ?int $created = null;

    #[ORM\Column(type: 'smallint', name: 'invitation_rank', options: ['comment' => ''])]
    private int $invitationRank = 0;

    #[ORM\Column(type: 'string', length: 10, nullable: true, name: 'cellphone')]
    private ?string $cellphone = null;

    #[ORM\Column(name: 'reinvite', type: 'integer', options: ['comment' => 'status du constancien'])]
    private int $reinvite = 0;

    // Getters et setters...
    #[ORM\OneToMany(targetEntity: ConstanciensArchivesBirthdate::class, mappedBy: 'constancien')]
    private Collection $archivesBirthdates;

    #[ORM\OneToMany(targetEntity: ConstanciensArchivesCes::class, mappedBy: 'constancien')]
    private Collection $archivesCes;

    #[ORM\OneToMany(targetEntity: ConstanciensArchivesEps::class, mappedBy: 'constancien')]
    private Collection $archivesEps;

    #[ORM\OneToMany(targetEntity: ConstanciensCoupon::class, mappedBy: 'constancien')]
    private Collection $coupons;

    public function __construct()
    {
        $this->archivesBirthdates = new ArrayCollection();
        $this->archivesCes = new ArrayCollection();
        $this->archivesEps = new ArrayCollection();
        $this->coupons = new ArrayCollection();
    }


    // (Autres getters et setters...)

    /**
     * @return Collection|ConstanciensArchivesBirthdate[]
     */
    public function getArchivesBirthdates(): Collection
    {
        return $this->archivesBirthdates;
    }

    public function addArchivesBirthdate(ConstanciensArchivesBirthdate $archivesBirthdate): self
    {
        if (!$this->archivesBirthdates->contains($archivesBirthdate)) {
            $this->archivesBirthdates[] = $archivesBirthdate;
            $archivesBirthdate->setConstancien($this);
        }

        return $this;
    }

    public function removeArchivesBirthdate(ConstanciensArchivesBirthdate $archivesBirthdate): self
    {
        if ($this->archivesBirthdates->removeElement($archivesBirthdate)) {
            // set the owning side to null (unless already changed)
            if ($archivesBirthdate->getConstancien() === $this) {
                $archivesBirthdate->setConstancien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ConstanciensArchivesCes[]
     */
    public function getArchivesCes(): Collection
    {
        return $this->archivesCes;
    }

    public function addArchivesCes(ConstanciensArchivesCes $archivesCes): self
    {
        if (!$this->archivesCes->contains($archivesCes)) {
            $this->archivesCes[] = $archivesCes;
            $archivesCes->setConstancien($this);
        }

        return $this;
    }

    public function removeArchivesCes(ConstanciensArchivesCes $archivesCes): self
    {
        if ($this->archivesCes->removeElement($archivesCes)) {
            // set the owning side to null (unless already changed)
            if ($archivesCes->getConstancien() === $this) {
                $archivesCes->setConstancien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ConstanciensArchivesEps[]
     */
    public function getArchivesEps(): Collection
    {
        return $this->archivesEps;
    }

    public function addArchivesEps(ConstanciensArchivesEps $archivesEps): self
    {
        if (!$this->archivesEps->contains($archivesEps)) {
            $this->archivesEps[] = $archivesEps;
            $archivesEps->setConstancien($this);
        }

        return $this;
    }

    public function removeArchivesEps(ConstanciensArchivesEps $archivesEps): self
    {
        if ($this->archivesEps->removeElement($archivesEps)) {
            // set the owning side to null (unless already changed)
            if ($archivesEps->getConstancien() === $this) {
                $archivesEps->setConstancien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ConstanciensCoupon[]
     */
    public function getCoupons(): Collection
    {
        return $this->coupons;
    }

    public function addCoupon(ConstanciensCoupon $coupon): self
    {
        if (!$this->coupons->contains($coupon)) {
            $this->coupons[] = $coupon;
            $coupon->setConstancien($this);
        }

        return $this;
    }

    public function removeCoupon(ConstanciensCoupon $coupon): self
    {
        if ($this->coupons->removeElement($coupon)) {
            // set the owning side to null (unless already changed)
            if ($coupon->getConstancien() === $this) {
                $coupon->setConstancien(null);
            }
        }

        return $this;
    }
    public function getConstancienId(): ?int
    {
        return $this->constancienId;
    }

    public function setConstancienId(int $constancienId): self
    {
        $this->constancienId = $constancienId;
        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getNamePatronymic(): ?string
    {
        return $this->namePatronymic;
    }

    public function setNamePatronymic(?string $namePatronymic): self
    {
        $this->namePatronymic = $namePatronymic;
        return $this;
    }

    public function getNameMarital(): ?string
    {
        return $this->nameMarital;
    }

    public function setNameMarital(?string $nameMarital): self
    {
        $this->nameMarital = $nameMarital;
        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(?int $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getBirthPlace(): ?string
    {
        return $this->birthPlace;
    }

    public function setBirthPlace(?string $birthPlace): self
    {
        $this->birthPlace = $birthPlace;
        return $this;
    }

    public function getBirthDate(): ?int
    {
        return $this->birthDate;
    }

    public function setBirthDate(?int $birthDate): self
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getInvitationMonth(): ?\DateTimeInterface
    {
        return $this->invitationMonth;
    }

    public function setInvitationMonth(?\DateTimeInterface $invitationMonth): self
    {
        $this->invitationMonth = $invitationMonth;
        return $this;
    }

    public function getCES(): ?RefCes
    {
        return $this->CES;
    }

    public function setCES(?RefCes $CES): self
    {
        $this->CES = $CES;
        return $this;
    }

    public function getCPAM(): ?RefCpam
    {
        return $this->CPAM;
    }

    public function setCPAM(?RefCpam $CPAM): self
    {
        $this->CPAM = $CPAM;
        return $this;
    }

    public function getCESPlace(): ?RefSite
    {
        return $this->CESPlace;
    }

    public function setCESPlace(?RefSite $CESPlace): self
    {
        $this->CESPlace = $CESPlace;
        return $this;
    }

    public function getAddressComplement(): ?string
    {
        return $this->addressComplement;
    }

    public function setAddressComplement(?string $addressComplement): self
    {
        $this->addressComplement = $addressComplement;
        return $this;
    }

    public function getAddressComplement2(): ?string
    {
        return $this->addressComplement2;
    }

    public function setAddressComplement2(?string $addressComplement2): self
    {
        $this->addressComplement2 = $addressComplement2;
        return $this;
    }

    public function getAddressNum(): ?string
    {
        return $this->addressNum;
    }

    public function setAddressNum(?string $addressNum): self
    {
        $this->addressNum = $addressNum;
        return $this;
    }

    public function getPostDeliver(): ?string
    {
        return $this->postDeliver;
    }

    public function setPostDeliver(?string $postDeliver): self
    {
        $this->postDeliver = $postDeliver;
        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function getExcluded(): int
    {
        return $this->excluded;
    }

    public function setExcluded(int $excluded): self
    {
        $this->excluded = $excluded;
        return $this;
    }

    public function getVolunteer(): int
    {
        return $this->volunteer;
    }

    public function setVolunteer(int $volunteer): self
    {
        $this->volunteer = $volunteer;
        return $this;
    }

    public function getValidatedFiche(): int
    {
        return $this->validatedFiche;
    }

    public function setValidatedFiche(int $validatedFiche): self
    {
        $this->validatedFiche = $validatedFiche;
        return $this;
    }

    public function getBirthDep(): ?string
    {
        return $this->birthDep;
    }

    public function setBirthDep(?string $birthDep): self
    {
        $this->birthDep = $birthDep;
        return $this;
    }

    public function getPointRemise(): ?string
    {
        return $this->pointRemise;
    }

    public function setPointRemise(?string $pointRemise): self
    {
        $this->pointRemise = $pointRemise;
        return $this;
    }

    public function getAdresseMention(): ?string
    {
        return $this->adresseMention;
    }

    public function setAdresseMention(?string $adresseMention): self
    {
        $this->adresseMention = $adresseMention;
        return $this;
    }

    public function getCodeCaisseGes(): ?string
    {
        return $this->codeCaisseGes;
    }

    public function setCodeCaisseGes(?string $codeCaisseGes): self
    {
        $this->codeCaisseGes = $codeCaisseGes;
        return $this;
    }

    public function getCodeCentrePaie(): ?string
    {
        return $this->codeCentrePaie;
    }

    public function setCodeCentrePaie(?string $codeCentrePaie): self
    {
        $this->codeCentrePaie = $codeCentrePaie;
        return $this;
    }

    public function getCodeRegime(): ?string
    {
        return $this->codeRegime;
    }

    public function setCodeRegime(?string $codeRegime): self
    {
        $this->codeRegime = $codeRegime;
        return $this;
    }

    public function getClass(): ?int
    {
        return $this->class;
    }

    public function setClass(?int $class): self
    {
        $this->class = $class;
        return $this;
    }

    public function getAddressUpdated(): ?int
    {
        return $this->addressUpdated;
    }

    public function setAddressUpdated(?int $addressUpdated): self
    {
        $this->addressUpdated = $addressUpdated;
        return $this;
    }

    public function getUpdated(): ?int
    {
        return $this->updated;
    }

    public function setUpdated(?int $updated): self
    {
        $this->updated = $updated;
        return $this;
    }

    public function getUpdatedPnd(): ?int
    {
        return $this->updatedPnd;
    }

    public function setUpdatedPnd(?int $updatedPnd): self
    {
        $this->updatedPnd = $updatedPnd;
        return $this;
    }

    public function getCreated(): ?int
    {
        return $this->created;
    }

    public function setCreated(?int $created): self
    {
        $this->created = $created;
        return $this;
    }

    public function getInvitationRank(): int
    {
        return $this->invitationRank;
    }

    public function setInvitationRank(int $invitationRank): self
    {
        $this->invitationRank = $invitationRank;
        return $this;
    }

    public function getCellphone(): ?string
    {
        return $this->cellphone;
    }

    public function setCellphone(?string $cellphone): self
    {
        $this->cellphone = $cellphone;
        return $this;
    }

    public function getReinvite(): int
    {
        return $this->reinvite;
    }

    public function setReinvite(int $reinvite): self
    {
        $this->reinvite = $reinvite;
        return $this;
    }
}
