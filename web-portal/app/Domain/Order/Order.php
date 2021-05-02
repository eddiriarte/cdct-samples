<?php


namespace App\Domain\Order;


use App\Domain\DomainObjectBuilder;
use Carbon\Carbon;

class Order
{
    use DomainObjectBuilder;

    private $id;

    private $customerId;

    private $orderedAt;

    private $address;

    private $grossTotal;

    private $taxRate;

    private $currency;

    public function getId(): string
    {
        return $this->id;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getOrderedAt(): Carbon
    {
        return Carbon::parse($this->orderedAt);
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getGrossTotal(): float
    {
        return $this->grossTotal;
    }

    public function getNetAmount(): float
    {
        return $this->grossTotal - $this->getTaxAmount();
    }

    public function getTaxAmount(): float
    {
        return ($this->grossTotal * $this->taxRate) / ($this->taxRate + 100);
    }

    public function getTaxRate(): float
    {
        return $this->taxRate;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customerId,
            'ordered_at' => $this->orderedAt,
            'address' => $this->address,
            'gross_total' => $this->grossTotal,
            'tax_tate' => $this->taxRate,
            'currency' => $this->currency,
        ];
    }
}
