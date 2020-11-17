<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(
     *     message = "Cet Email '{{ value }}' n'est pas valide."
     * )
     * @Assert\NotBlank (
     *      message = "Champs vide"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank (
     *      message = "Champs vide"
     * )
     * @Assert\Regex(
     *     pattern="/(^[a-zA-ZÀ-ú\-\s])+/",
     *     message="Saisie incorrect, exemple: Silverster"
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank (
     *      message = "Champs vide"
     * )
     * @Assert\Regex(
     *     pattern="/(^[a-zA-ZÀ-ú\-\s])+/",
     *     message="Saisie incorrect, exemple: Stallone"
     * )
     */
    private $firstname;


    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank (
     *      message = "Champs vide"
     * )
     * @Assert\Regex(
     *     pattern="/^[[:alpha:]]([-' ]?[[:alpha:]])*$/",
     *     message="Saisie incorrect, exemple:Maison-Alfort"
     * )
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\NotBlank (
     *      message = "Champs vide"
     * )
     * @Assert\Regex(
     *     pattern="/(^[0-9a-zA-ZÀ-ú\-\s])+/",
     *     message="Saisie incorrect, exemple: 76350"
     * )
     */
    private $city_code;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank (
     *      message = "Champs vide"
     * )
     * @Assert\Regex(
     *     pattern="/(^[0-9a-zA-ZÀ-ú\-\s])+/",
     *     message="Saisie incorrect, exemple: 2 rue de Lisbonne"
     * )
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=1)
     * @Assert\Choice(
     *     choices = { "M", "F" },
     *     message = "Choisir un genre."
     * )
     * @Assert\NotBlank (
     *      message = "Champs vide"
     * )
     */
    private $sex;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThan("-18 years")
     * @Assert\NotBlank
     */
    private $birthdate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Account::class, mappedBy="user", orphanRemoval=true)
     */
    private $accounts;

    /**
     * @ORM\OneToMany(targetEntity=Operation::class, mappedBy="user", orphanRemoval=true)
     */
    private $operations;

    public function __construct()
    {
        $this->accounts = new ArrayCollection();
        $this->operations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCityCode(): ?string
    {
        return $this->city_code;
    }

    public function setCityCode(string $city_code): self
    {
        $this->city_code = $city_code;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection|Account[]
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function addAccount(Account $account): self
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts[] = $account;
            $account->setUser($this);
        }

        return $this;
    }

    public function removeAccount(Account $account): self
    {
        if ($this->accounts->removeElement($account)) {
            // set the owning side to null (unless already changed)
            if ($account->getUser() === $this) {
                $account->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Operation[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): self
    {
        if (!$this->operations->contains($operation)) {
            $this->operations[] = $operation;
            $operation->setUser($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getUser() === $this) {
                $operation->setUser(null);
            }
        }

        return $this;
    }
}
