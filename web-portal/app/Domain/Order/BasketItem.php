<?php


namespace App\Domain\Order;


use App\Domain\DomainObjectBuilder;

class BasketItem
{
    use DomainObjectBuilder;

    private $articleNumber;

    private $description;

    private $quantity;

    private $unitPriceGross;

    private $taxRate;

    /**
     * @return mixed
     */
    public function getArticleNumber()
    {
        return $this->articleNumber;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return mixed
     */
    public function getUnitPriceGross()
    {
        return $this->unitPriceGross;
    }

    /**
     * @return mixed
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    public function toArray(): array
    {
        return [
            'article_number' => $this->articleNumber,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'unit_price_gross' => $this->unitPriceGross,
            'tax_rate' => $this->taxRate,
        ];
    }
}
