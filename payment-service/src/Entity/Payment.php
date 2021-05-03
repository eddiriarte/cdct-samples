<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 * @ORM\Table(name="`payment`")
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $transferredAt;

    /**
     * @ORM\Column(type="guid")
     */
    private $orderId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getTransferredAt(): ?\DateTimeInterface
    {
        return $this->transferredAt;
    }

    public function setTransferredAt(\DateTimeInterface $transferredAt): self
    {
        $this->transferredAt = $transferredAt;

        return $this;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function setOrderId(string $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'amount' => (float)$this->amount,
            'transferred_at' => $this->getTransferredAt()->format(\DateTimeInterface::ATOM),
            'order_id' => $this->orderId,
            'description' => $this->description,
        ];
    }
}
