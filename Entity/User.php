<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use App\Repository\UserRepository;
use App\Enum\Status;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\Index(name: 'first_name_idx', columns: ['firstName'])]
#[ORM\Index(name: 'last_name_idx', columns: ['lastName'])]
#[ORM\Index(name: 'email_idx', columns: ['email'])]
#[ORM\Index(name: 'status_idx', columns: ['status'])]
#[UniqueEntity('email', message: 'global.email_already_exists')]
class User implements  UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['comment' => "ID unique de l'utilisateur généré par Symfony"])]
    private ?int $id = null;

    #[ORM\Column(length: 180, options: ['comment' => "L'adresse email de l'utilisateur"])]
    private ?string $email = null;

    #[ORM\Column(options: ['comment' => "Le rôle de l'utilisateur. Devrait être unique. Exemple: ['ROLE_TC']"])]
    private array $roles = [];

    #[ORM\Column(options: ['comment' => 'Mot de passe hashé'])]
    private ?string $password = null;

    #[ORM\Column(nullable: true, options: ['comment' => 'Date de la dernière modification du mot de passe'])]
    private ?\DateTime $passwordLastChange = null;

    #[ORM\Column(type: 'string', enumType: Status::class, length: 80, options: ['comment' => "Le statut de l'utilisateur"])]
    private ?Status $status = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['comment' => "Vrai si l'utilisateur doit changer de MDP"])]
    private ?bool $mustChangePassword = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\ManyToOne(targetEntity: RefCes::class)]
    #[ORM\JoinColumn(referencedColumnName: 'ces_id', nullable: true, options: ['comment' => "Référence vers le CES"])]
    private ?RefCes $ces = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPasswordLastChange(): ?\DateTime
    {
        return $this->passwordLastChange;
    }

    public function setPasswordLastChange(?\DateTime $passwordLastChange): static
    {
        $this->passwordLastChange = $passwordLastChange;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    /**
     * Pour désactiver un utilisateur, on utilisera App\Service\SecurityService->deactivateUser()
     */
    public function setStatus(Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getMustChangePassword(): ?bool
    {
        return $this->mustChangePassword;
    }

    public function setMustChangePassword(bool $mustChangePassword): self
    {
        $this->mustChangePassword = $mustChangePassword;

        return $this;
    }


    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getCes(): ?RefCes
    {
        return $this->ces;
    }

    public function setCes(?RefCes $ces): static
    {
        $this->ces = $ces;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // Efface les informations sensibles si nécessaire
    }

    // Ajout de la méthode pour obtenir le premier rôle comme profileType
    public function getProfileType(): ?string
    {
        return $this->roles[0] ?? null;
    }

}
