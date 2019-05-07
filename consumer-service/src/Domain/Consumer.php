<?php

namespace EddIriarte\Consumer\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="EddIriarte\Consumer\Entity\ConsumerRepository")
 * @ORM\Table(name="consumers")
 */
class Consumer
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
     * @var string
     * 
     * @ORM\Column(type="string", name="first_name", length=200)
     */
    private $firstName;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="last_name", length=200)
     */
    private $lastName;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var ArrayCollection<Address>
     * 
     * @ORM\OneToMany(targetEntity="Address", mappedBy="consumer")
     */
    private $addresses;

    public function __contruct()
    {
        $this->addresses = new ArrayCollection();
    }

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
     * Get the value of firstName
     *
     * @return  string
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @param  string  $firstName
     *
     * @return  self
     */ 
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     *
     * @return  string
     */ 
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @param  string  $lastName
     *
     * @return  self
     */ 
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     *
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);

        return $this;
    }
}
