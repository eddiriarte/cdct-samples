<?php

namespace EddIriarte\Payment\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="EddIriarte\Payment\Repository\TransferRepository")
 */
class Transfer
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Column(type="uuid")
     */
    private $orderId;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal")
     */
    private $amount;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="date_immutable")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptions;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=200)
     */
    private $iban;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="bank_name", length=200)
     */
    private $bankName;

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    /**
     * Get the value of orderId
     *
     * @return  \Ramsey\Uuid\UuidInterface
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set the value of orderId
     *
     * @param  \Ramsey\Uuid\UuidInterface  $orderId
     *
     * @return  self
     */
    public function setOrderId(\Ramsey\Uuid\UuidInterface $orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get the value of amount
     *
     * @return  string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @param  string  $amount
     *
     * @return  self
     */
    public function setAmount(string $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of date
     *
     * @return  \DateTimeImmutable
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @param  \DateTimeImmutable  $date
     *
     * @return  self
     */
    public function setDate(\DateTimeImmutable $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of descriptions
     *
     * @return  string
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }

    /**
     * Set the value of descriptions
     *
     * @param  string  $descriptions
     *
     * @return  self
     */
    public function setDescriptions(string $descriptions)
    {
        $this->descriptions = $descriptions;

        return $this;
    }

    /**
     * Get the value of iban
     *
     * @return  string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Set the value of iban
     *
     * @param  string  $iban
     *
     * @return  self
     */
    public function setIban(string $iban)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * Get the value of bankName
     *
     * @return  string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * Set the value of bankName
     *
     * @param  string  $bankName
     *
     * @return  self
     */
    public function setBankName(string $bankName)
    {
        $this->bankName = $bankName;

        return $this;
    }
}
