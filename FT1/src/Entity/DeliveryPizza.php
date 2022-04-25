<?php

namespace App\Entity;

use App\Repository\DeliveryPizzaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliveryPizzaRepository::class)
 */
class DeliveryPizza
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pizzaName;

    /**
     * @ORM\Column(type="integer")
     */
    private $pizzaPrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pizzaComposition;

    /**
     * @ORM\OneToMany(targetEntity=DeliveryKit::class, mappedBy="deliveryPizzaInKit")
     */
    private $deliveryKits;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pizzaSize;

    public function __construct()
    {
        $this->deliveryKits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPizzaName(): ?string
    {
        return $this->pizzaName;
    }

    public function setPizzaName(string $pizzaName): self
    {
        $this->pizzaName = $pizzaName;

        return $this;
    }

    public function getPizzaPrice(): ?int
    {
        return $this->pizzaPrice;
    }

    public function setPizzaPrice(int $pizzaPrice): self
    {
        $this->pizzaPrice = $pizzaPrice;

        return $this;
    }

    public function getPizzaComposition(): ?string
    {
        return $this->pizzaComposition;
    }

    public function setPizzaComposition(?string $pizzaComposition): self
    {
        $this->pizzaComposition = $pizzaComposition;

        return $this;
    }

    /**
     * @return Collection|DeliveryKit[]
     */
    public function getDeliveryKits(): Collection
    {
        return $this->deliveryKits;
    }

    public function addDeliveryKit(DeliveryKit $deliveryKit): self
    {
        if (!$this->deliveryKits->contains($deliveryKit)) {
            $this->deliveryKits[] = $deliveryKit;
            $deliveryKit->setDeliveryPizzaInKit($this);
        }

        return $this;
    }

    public function removeDeliveryKit(DeliveryKit $deliveryKit): self
    {
        if ($this->deliveryKits->removeElement($deliveryKit)) {
            // set the owning side to null (unless already changed)
            if ($deliveryKit->getDeliveryPizzaInKit() === $this) {
                $deliveryKit->setDeliveryPizzaInKit(null);
                $deliveryKit->setSessionId(null);
            }
        }

        return $this;
    }

    public function getPizzaSize(): ?int
    {
        return $this->pizzaSize;
    }

    public function setPizzaSize(?int $pizzaSize): self
    {
        $this->pizzaSize = $pizzaSize;

        return $this;
    }
}
