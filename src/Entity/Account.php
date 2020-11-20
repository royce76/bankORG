<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\AccountRepository;


/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank (
     *      message = "Champs vide"
     * )
     */
    private $account_type;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank (
     *      message = "Champs vide"
     * )
     * @Assert\LessThanOrEqual("today", message = "Votre date d'ouverture est incorrecte")
     */
    private $opening_date;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank (
     *      message = "Champs vide"
     * )
     * @Assert\GreaterThanOrEqual (
     *      value = 0,
     *      message = "Solde insuffisant",
     * )
     */
    private $balance;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="accounts")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Operation::class, mappedBy="account", orphanRemoval=true)
     */
    private $operations;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountType(): ?string
    {
        return $this->account_type;
    }

    public function setAccountType(string $account_type): self
    {
        $this->account_type = $account_type;

        return $this;
    }

    public function getOpeningDate(): ?\DateTimeInterface
    {
        $this->opening_date = new \DateTime('today');
        return $this->opening_date;
    }

    public function setOpeningDate(\DateTimeInterface $opening_date): self
    {
        $this->opening_date = $opening_date;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $operation->setAccount($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getAccount() === $this) {
                $operation->setAccount(null);
            }
        }

        return $this;
    }
}
