<?php

namespace App\Entity;

use App\Repository\DeliveryOrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliveryOrderRepository::class)
 */
class DeliveryOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $orderAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $orderSessionId;

    /**
     * @ORM\ManyToOne(targetEntity=DeliveryKit::class, inversedBy="deliveryOrders")
     */
    private $orderKit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $orderClientNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderClientId;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $orderDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderAddress(): ?string
    {
        return $this->orderAddress;
    }

    public function setOrderAddress(?string $orderAddress): self
    {
        $this->orderAddress = $orderAddress;

        return $this;
    }

    public function getOrderSessionId(): ?string
    {
        return $this->orderSessionId;
    }

    public function setOrderSessionId(?string $orderSessionId): self
    {
        $this->orderSessionId = $orderSessionId;

        return $this;
    }

    public function getOrderKit(): ?DeliveryKit
    {
        return $this->orderKit;
    }

    public function setOrderKit(?DeliveryKit $orderKit): self
    {
        $this->orderKit = $orderKit;

        return $this;
    }

    public function getOrderClientNumber(): ?string
    {
        return $this->orderClientNumber;
    }

    public function setOrderClientNumber(?string $orderClientNumber): self
    {
        $this->orderClientNumber = $orderClientNumber;

        return $this;
    }

    public function getOrderClientId(): ?int
    {
        return $this->orderClientId;
    }

    public function setOrderClientId(int $orderClientId): self
    {
        $this->orderClientId = $orderClientId;

        return $this;
    }

    public function __construct()
    {

        $this->setOrderDate(new \DateTime());

    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(?\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }
}
