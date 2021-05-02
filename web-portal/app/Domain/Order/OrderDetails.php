<?php


namespace App\Domain\Order;


use App\Domain\DomainObjectBuilder;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class OrderDetails
{
    use DomainObjectBuilder;

    private $id;

    private $customer;

    private $orderedAt;

    private $address;

    private $grossTotal;

    private $taxRate;

    private $currency;

    private $basket;

    private $payments;

    public function getId(): string
    {
        return $this->id;
    }

    public function getCustomer(): Customer
    {
        return Customer::make($this->customer);
    }

    public function getOrderedAt(): Carbon
    {
        return Carbon::parse($this->orderedAt);
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getGrossTotal(): string
    {
        return $this->grossTotal;
    }

    public function getTaxRate(): float
    {
        return $this->taxRate;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getBasket(): Collection
    {
        return collect($this->basket)
            ->map(fn (array $item) => BasketItem::make($item));
    }

    public function getPayments(): Collection
    {
        return collect($this->payments)
            ->map(fn (array $item) => Payment::make($item));
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'customer' => $this->customer,
            'ordered_at' => $this->orderedAt,
            'address' => $this->address,
            'gross_total' => $this->grossTotal,
            'tax_tate' => $this->taxRate,
            'currency' => $this->currency,
            'basket' => $this->basket,
            'payments' => $this->payments,
        ];
    }
}
