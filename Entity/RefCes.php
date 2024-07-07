<?php

namespace App\Entity;

use App\Repository\RefCesRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: RefCesRepository::class)]
#[ORM\Table(name: 'ref_ces')]
class RefCes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'ces_id', type: 'integer', options: ['comment' => "L'identifiant unique du CES"])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, options: ['comment' => "Le nom court du CES"])]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255, options: ['comment' => "Le nom long du CES"])]
    private ?string $fieldNameValue = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => "Le numéro et voie de l'adresse du CES"])]
    private ?string $fieldAddressValue = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => "Le CEDEX de l'adresse du CES"])]
    private ?string $fieldCedexValue = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => "Le code postal de l'adresse du CES"])]
    private ?string $fieldPostcodeValue = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => "La ville de l'adresse du CES"])]
    private ?string $fieldCityValue = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => "La boite postale de l'adresse du CES"])]
    private ?string $fieldPoBoxValue = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => "Le numéro de téléphone du CES"])]
    private ?string $fieldPhoneValue = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true, options: ['comment' => "Le numéro de fax du CES"])]
    private ?string $fieldFaxValue = null;

    #[ORM\Column(type: 'integer', nullable: true, options: ['unsigned' => true, 'comment' => "Le nombre maximum de rdv par heure du CES"])]
    private ?int $fieldNbMaxRdvValue = null;

    #[ORM\Column(type: 'integer', nullable: true, options: ['unsigned' => true, 'comment' => "Le flag de convocation dans le passé du CES"])]
    private ?int $fieldPastConvocValue = null;

    #[ORM\Column(type: 'integer', nullable: true, options: ['unsigned' => true, 'comment' => "L'id du sous-site par défaut du CES si multi-site"])]
    private ?int $fieldDefaultSiteValue = null;


    #[ORM\OneToMany(mappedBy: 'refCes', targetEntity: RefCpam::class)]
    private Collection $cpams;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'ces')]
    private Collection $users;

    #[ORM\OneToMany(targetEntity: RefSite::class, mappedBy: 'refCes')]
    private Collection $sites;

    public function __construct()
    {
        $this->cpams = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->sites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFieldNameValue(): ?string
    {
        return $this->fieldNameValue;
    }

    public function setFieldNameValue(string $fieldNameValue): self
    {
        $this->fieldNameValue = $fieldNameValue;

        return $this;
    }

    public function getFieldAddressValue(): ?string
    {
        return $this->fieldAddressValue;
    }

    public function setFieldAddressValue(?string $fieldAddressValue): self
    {
        $this->fieldAddressValue = $fieldAddressValue;

        return $this;
    }

    public function getFieldCedexValue(): ?string
    {
        return $this->fieldCedexValue;
    }

    public function setFieldCedexValue(?string $fieldCedexValue): self
    {
        $this->fieldCedexValue = $fieldCedexValue;

        return $this;
    }

    public function getFieldPostcodeValue(): ?string
    {
        return $this->fieldPostcodeValue;
    }

    public function setFieldPostcodeValue(?string $fieldPostcodeValue): self
    {
        $this->fieldPostcodeValue = $fieldPostcodeValue;

        return $this;
    }

    public function getFieldCityValue(): ?string
    {
        return $this->fieldCityValue;
    }

    public function setFieldCityValue(?string $fieldCityValue): self
    {
        $this->fieldCityValue = $fieldCityValue;

        return $this;
    }

    public function getFieldPoBoxValue(): ?string
    {
        return $this->fieldPoBoxValue;
    }

    public function setFieldPoBoxValue(?string $fieldPoBoxValue): self
    {
        $this->fieldPoBoxValue = $fieldPoBoxValue;

        return $this;
    }

    public function getFieldPhoneValue(): ?string
    {
        return $this->fieldPhoneValue;
    }

    public function setFieldPhoneValue(?string $fieldPhoneValue): self
    {
        $this->fieldPhoneValue = $fieldPhoneValue;

        return $this;
    }

    public function getFieldFaxValue(): ?string
    {
        return $this->fieldFaxValue;
    }

    public function setFieldFaxValue(?string $fieldFaxValue): self
    {
        $this->fieldFaxValue = $fieldFaxValue;

        return $this;
    }

    public function getFieldNbMaxRdvValue(): ?int
    {
        return $this->fieldNbMaxRdvValue;
    }

    public function setFieldNbMaxRdvValue(?int $fieldNbMaxRdvValue): self
    {
        $this->fieldNbMaxRdvValue = $fieldNbMaxRdvValue;

        return $this;
    }

    public function getFieldPastConvocValue(): ?int
    {
        return $this->fieldPastConvocValue;
    }

    public function setFieldPastConvocValue(?int $fieldPastConvocValue): self
    {
        $this->fieldPastConvocValue = $fieldPastConvocValue;

        return $this;
    }

    public function getFieldDefaultSiteValue(): ?int
    {
        return $this->fieldDefaultSiteValue;
    }

    public function setFieldDefaultSiteValue(?int $fieldDefaultSiteValue): self
    {
        $this->fieldDefaultSiteValue = $fieldDefaultSiteValue;

        return $this;
    }

    /**
     * @return Collection|User[]
     */

    /**
     * @return Collection|RefSite[]
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    public function addSite(RefSite $site): self
    {
        if (!$this->sites->contains($site)) {
            $this->sites[] = $site;
            $site->setRefCes($this);
        }

        return $this;
    }

    public function removeSite(RefSite $site): self
    {
        if ($this->sites->removeElement($site)) {
            // set the owning side to null (unless already changed)
            if ($site->getRefCes() === $this) {
                $site->setRefCes(null);
            }
        }

        return $this;
    }

    public function getCpams(): Collection
    {
        return $this->cpams;
    }

    public function addCpam(RefCpam $cpam): self
    {
        if (!$this->cpams->contains($cpam)) {
            $this->cpams[] = $cpam;
            $cpam->setRefCes($this);
        }

        return $this;
    }

    public function removeCpam(RefCpam $cpam): self
    {
        if ($this->cpams->contains($cpam)) {
            $this->cpams->removeElement($cpam);
            // set the owning side to null (unless already changed)
            if ($cpam->getRefCes() === $this) {
                $cpam->setRefCes(null);
            }
        }

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setRefCes($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getRefCes() === $this) {
                $user->setRefCes(null);
            }
        }

        return $this;
    }
}
