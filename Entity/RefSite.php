<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\RefSiteRepository;

#[ORM\Entity(repositoryClass: RefSiteRepository::class)]
#[ORM\Table(name: 'ref_site', options: ['comment' => 'Table des Sites'])]
class RefSite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name: 'site_id', options: ['comment' => 'L\'identifiant unique du site'])]
    private ?int $siteId = null;

    #[ORM\ManyToOne(targetEntity: RefCes::class, inversedBy: 'sites')]
    #[ORM\JoinColumn(name: 'ref_ces_id', referencedColumnName: 'ces_id', nullable: false, options: ['comment' => 'L\'identifiant unique du CES du site'])]
    private ?RefCes $refCes = null;

    #[ORM\Column(type: 'string', length: 255, name: 'title', options: ['comment' => 'Le nom court du CES'])]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255, name: 'field_name_value', options: ['comment' => 'Le nom long du CES'])]
    private ?string $fieldNameValue = null;

    #[ORM\Column(type: 'string', length: 255, name: 'field_address_value', nullable: true, options: ['comment' => 'Le numéro et voie de l\'adresse du site'])]
    private ?string $fieldAddressValue = null;

    #[ORM\Column(type: 'string', length: 255, name: 'field_cedex_value', nullable: true, options: ['comment' => 'Le CEDEX de l\'adresse du site'])]
    private ?string $fieldCedexValue = null;

    #[ORM\Column(type: 'string', length: 255, name: 'field_postcode_value', nullable: true, options: ['comment' => 'Le code postal de l\'adresse du site'])]
    private ?string $fieldPostcodeValue = null;

    #[ORM\Column(type: 'string', length: 255, name: 'field_city_value', nullable: true, options: ['comment' => 'La ville de l\'adresse du site'])]
    private ?string $fieldCityValue = null;

    #[ORM\Column(type: 'string', length: 255, name: 'field_po_box_value', nullable: true, options: ['comment' => 'La boite postale l\'adresse du site'])]
    private ?string $fieldPoBoxValue = null;

    #[ORM\Column(type: 'string', length: 255, name: 'field_phone_value', nullable: true, options: ['comment' => 'Le numéro de téléphone du site'])]
    private ?string $fieldPhoneValue = null;

    #[ORM\Column(type: 'string', length: 255, name: 'field_fax_value', nullable: true, options: ['comment' => 'Le numéro de fax du site'])]
    private ?string $fieldFaxValue = null;

    #[ORM\Column(type: 'integer', name: 'field_nb_max_rdv_value', nullable: true, options: ['comment' => 'Le nombre maximum de rdv par heure du site'])]
    private ?int $fieldNbMaxRdvValue = null;

    #[ORM\Column(type: 'integer', name: 'field_past_convoc_value', nullable: true, options: ['comment' => 'Le flag de convocation dans le passé du site'])]
    private ?int $fieldPastConvocValue = null;


    // Getters et setters...

    public function getSiteId(): ?int
    {
        return $this->siteId;
    }

    public function setSiteId(int $siteId): self
    {
        $this->siteId = $siteId;
        return $this;
    }

    public function getRefCes(): ?RefCes
    {
        return $this->refCes;
    }

    public function setRefCes(?RefCes $refCes): self
    {
        $this->refCes = $refCes;
        return $this;
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

}
