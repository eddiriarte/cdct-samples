<?php


namespace App\Domain\Order;


use App\Domain\DomainObjectBuilder;

class Payment
{
    use DomainObjectBuilder;

    private $id;

    private $amount;

    private $transferred_at;

    private $description;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getTransferredAt()
    {
        return $this->transferred_at;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'transferred_at' => $this->transferred_at,
            'description' => $this->description,
        ];
    }
}
