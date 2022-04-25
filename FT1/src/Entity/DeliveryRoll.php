<?php

namespace App\Entity;

use App\Repository\DeliveryRollRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliveryRollRepository::class)
 */
class DeliveryRoll
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
    private $rollName;

    /**
     * @ORM\Column(type="integer")
     */
    private $rollPrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rollComposition;

    /**
     * @ORM\OneToMany(targetEntity=DeliveryKit::class, mappedBy="deliveryRollInKit")
     */
    private $deliveryKits;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rollQuantity;

    public function __construct()
    {
        $this->deliveryKits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRollName(): ?string
    {
        return $this->rollName;
    }

    public function setRollName(string $rollName): self
    {
        $this->rollName = $rollName;

        return $this;
    }

    public function getRollPrice(): ?int
    {
        return $this->rollPrice;
    }

    public function setRollPrice(int $rollPrice): self
    {
        $this->rollPrice = $rollPrice;

        return $this;
    }

    public function getRollComposition(): ?string
    {
        return $this->rollComposition;
    }

    public function setRollComposition(?string $rollComposition): self
    {
        $this->rollComposition = $rollComposition;

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
            $deliveryKit->setDeliveryRollInKit($this);
        }

        return $this;
    }

    public function removeDeliveryKit(DeliveryKit $deliveryKit): self
    {
        if ($this->deliveryKits->removeElement($deliveryKit)) {
            // set the owning side to null (unless already changed)
            if ($deliveryKit->getDeliveryRollInKit() === $this) {
                $deliveryKit->setDeliveryRollInKit(null);
                $deliveryKit->setSessionId(null);
            }
        }

        return $this;
    }

    public function getRollQuantity(): ?int
    {
        return $this->rollQuantity;
    }

    public function setRollQuantity(?int $rollQuantity): self
    {
        $this->rollQuantity = $rollQuantity;

        return $this;
    }
}
