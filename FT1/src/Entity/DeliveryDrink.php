<?php

namespace App\Entity;

use App\Repository\DeliveryDrinkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliveryDrinkRepository::class)
 */
class DeliveryDrink
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
    private $drinkName;

    /**
     * @ORM\Column(type="integer")
     */
    private $drinkPrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $drinkComposition;

    /**
     * @ORM\OneToMany(targetEntity=DeliveryKit::class, mappedBy="deliveryDrinkInKit")
     */
    private $deliveryKits;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $drinkVolume;

    public function __construct()
    {
        $this->deliveryKits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDrinkName(): ?string
    {
        return $this->drinkName;
    }

    public function setDrinkName(string $drinkName): self
    {
        $this->drinkName = $drinkName;

        return $this;
    }

    public function getDrinkPrice(): ?int
    {
        return $this->drinkPrice;
    }

    public function setDrinkPrice(int $drinkPrice): self
    {
        $this->drinkPrice = $drinkPrice;

        return $this;
    }

    public function getDrinkComposition(): ?string
    {
        return $this->drinkComposition;
    }

    public function setDrinkComposition(?string $drinkComposition): self
    {
        $this->drinkComposition = $drinkComposition;

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
            $deliveryKit->setDeliveryDrinkInKit($this);
        }

        return $this;
    }

    public function removeDeliveryKit(DeliveryKit $deliveryKit): self
    {
        if ($this->deliveryKits->removeElement($deliveryKit)) {
            // set the owning side to null (unless already changed)
            if ($deliveryKit->getDeliveryDrinkInKit() === $this) {
                $deliveryKit->setDeliveryDrinkInKit(null);
                $deliveryKit->setSessionId(null);
            }
        }

        return $this;
    }

    public function getDrinkVolume(): ?int
    {
        return $this->drinkVolume;
    }

    public function setDrinkVolume(?int $drinkVolume): self
    {
        $this->drinkVolume = $drinkVolume;

        return $this;
    }
}
