<?php

namespace App\Entity;

use App\Repository\DeliveryKitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliveryKitRepository::class)
 */
class DeliveryKit
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
    private $sessionId;

    /**
     * @ORM\ManyToOne(targetEntity=DeliveryPizza::class, inversedBy="deliveryKits")
     */
    private $deliveryPizzaInKit;

    /**
     * @ORM\ManyToOne(targetEntity=DeliveryDrink::class, inversedBy="deliveryKits")
     */
    private $deliveryDrinkInKit;

    /**
     * @ORM\ManyToOne(targetEntity=DeliveryRoll::class, inversedBy="deliveryKits")
     */
    private $deliveryRollInKit;

    /**
     * @ORM\OneToMany(targetEntity=DeliveryOrder::class, mappedBy="orderKit")
     */
    private $deliveryOrders;

    public function __construct()
    {
        $this->deliveryOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(?string $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function getDeliveryPizzaInKit(): ?DeliveryPizza
    {
        return $this->deliveryPizzaInKit;
    }

    public function setDeliveryPizzaInKit(?DeliveryPizza $deliveryPizzaInKit): self
    {
        $this->deliveryPizzaInKit = $deliveryPizzaInKit;

        return $this;
    }

    public function getDeliveryDrinkInKit(): ?DeliveryDrink
    {
        return $this->deliveryDrinkInKit;
    }

    public function setDeliveryDrinkInKit(?DeliveryDrink $deliveryDrinkInKit): self
    {
        $this->deliveryDrinkInKit = $deliveryDrinkInKit;

        return $this;
    }

    public function getDeliveryRollInKit(): ?DeliveryRoll
    {
        return $this->deliveryRollInKit;
    }

    public function setDeliveryRollInKit(?DeliveryRoll $deliveryRollInKit): self
    {
        $this->deliveryRollInKit = $deliveryRollInKit;

        return $this;
    }

    /**
     * @return Collection|DeliveryOrder[]
     */
    public function getDeliveryOrders(): Collection
    {
        return $this->deliveryOrders;
    }

    public function addDeliveryOrder(DeliveryOrder $deliveryOrder): self
    {
        if (!$this->deliveryOrders->contains($deliveryOrder)) {
            $this->deliveryOrders[] = $deliveryOrder;
            $deliveryOrder->setOrderKit($this);
        }

        return $this;
    }

    public function removeDeliveryOrder(DeliveryOrder $deliveryOrder): self
    {
        if ($this->deliveryOrders->removeElement($deliveryOrder)) {
            // set the owning side to null (unless already changed)
            if ($deliveryOrder->getOrderKit() === $this) {
                $deliveryOrder->setOrderKit(null);
            }
        }

        return $this;
    }
}
