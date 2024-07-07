<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConstanciensCouponRepository;

#[ORM\Entity(repositoryClass: ConstanciensCouponRepository::class)]
#[ORM\Table(name: 'constanciens_coupon')]
class ConstanciensCoupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name: 'coupon_id', options: ['comment' => 'ID unique du coupon'])]
    private ?int $couponId = null;

    #[ORM\ManyToOne(targetEntity: Constanciens::class)]
    #[ORM\JoinColumn(nullable: false, name: 'constancien_id', referencedColumnName: 'constancien_id')]
    private ?Constanciens $constancien = null;

    #[ORM\Column(type: 'string', length: 255, name: 'coupon_code', options: ['comment' => 'Code du coupon'])]
    private ?string $couponCode = null;

    #[ORM\Column(type: 'datetime', name: 'expiration_date', options: ['comment' => 'Date d\'expiration du coupon'])]
    private ?\DateTimeInterface $expirationDate = null;

    public function getCouponId(): ?int
    {
        return $this->couponId;
    }

    public function getConstancien(): ?Constanciens
    {
        return $this->constancien;
    }

    public function setConstancien(?Constanciens $constancien): self
    {
        $this->constancien = $constancien;
        return $this;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    public function setCouponCode(string $couponCode): self
    {
        $this->couponCode = $couponCode;
        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }
}
