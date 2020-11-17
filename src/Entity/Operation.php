<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 */
class Operation
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
    private $operation_type;

    /**
     * @ORM\Column(type="float")
     * @Assert\Regex(
     *      pattern = "/^([0-9]+([.][0-9]*)?|[.][0-9]+)$/",
     *      message = "Exemple de montant : 59.6 ou 1654,45"
     * )
     * @Assert\NotBlank (
     *      message = "Champs vide"
     * )
     */
    private $amount;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank (
     *      message = "Champs vide"
     * )
     */
    private $comments;

    /**
     * @ORM\Column(type="date")
     */
    private $date_transaction;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank (
     *      message = "Champs vide"
     * )
     */
    private $account;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperationType(): ?string
    {
        return $this->operation_type;
    }

    public function setOperationType(string $operation_type): self
    {
        $this->operation_type = $operation_type;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getDateTransaction(): ?\DateTimeInterface
    {
        return $this->date_transaction;
    }

    public function setDateTransaction(\DateTimeInterface $date_transaction): self
    {
        $this->date_transaction = $date_transaction;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

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
}
