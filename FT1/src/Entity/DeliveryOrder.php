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
}
