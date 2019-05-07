<?php

namespace EddIriarte\Consumer\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="EddIriarte\Consumer\Entity\AddressRepository")
 * @ORM\Table(name="addresses")
 */
class Address
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
     * @var Consumer
     * 
     * @ORM\ManyToOne(targetEntity="Consumer", inversedBy="addresses")
     * @ORM\JoinColumn(name="consumer_id", referencedColumnName="id")
     */
    private $consumer;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="additional", length=255, nullable=true)
     */
    private $additionalFields;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="zip", length=10, nullable=true)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="country", length=4, nullable=true)
     */
    private $countryCode;

    /**
     * Get the value of id
     *
     * @return  \Ramsey\Uuid\UuidInterface
     */ 
    public function getId()
    {
        return $this->id;
    }


    /**
     * Get the value of consumer
     *
     * @return  Consumer
     */ 
    public function getConsumer(): Consumer
    {
        return $this->consumer;
    }

    /**
     * Set the value of consumer
     *
     * @param  Consumer  $consumer
     *
     * @return  self
     */ 
    public function setConsumer(Consumer $consumer)
    {
        $this->consumer = $consumer;

        return $this;
    }

    /**
     * Get the value of street
     *
     * @return  string
     */ 
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set the value of street
     *
     * @param  string  $street
     *
     * @return  self
     */ 
    public function setStreet(string $street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get the value of additionalFields
     *
     * @return  string
     */ 
    public function getAdditionalFields()
    {
        return $this->additionalFields;
    }

    /**
     * Set the value of additionalFields
     *
     * @param  string  $additionalFields
     *
     * @return  self
     */ 
    public function setAdditionalFields(string $additionalFields)
    {
        $this->additionalFields = $additionalFields;

        return $this;
    }

    /**
     * Get the value of postalCode
     *
     * @return  string
     */ 
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set the value of postalCode
     *
     * @param  string  $postalCode
     *
     * @return  self
     */ 
    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get the value of city
     *
     * @return  string
     */ 
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @param  string  $city
     *
     * @return  self
     */ 
    public function setCity(string $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of state
     *
     * @return  string
     */ 
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @param  string  $state
     *
     * @return  self
     */ 
    public function setState(string $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get the value of countryCode
     *
     * @return  string
     */ 
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set the value of countryCode
     *
     * @param  string  $countryCode
     *
     * @return  self
     */ 
    public function setCountryCode(string $countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }
}
