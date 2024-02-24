<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=OrderLine::class, mappedBy="order_number")
     */
    private $Order_Lines;

    public function __construct()
    {
        $this->Order_Lines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, OrderLine>
     */
    public function getOrderLines(): Collection
    {
        return $this->Order_Lines;
    }

    public function addOrderLine(OrderLine $orderLine): self
    {
        if (!$this->Order_Lines->contains($orderLine)) {
            $this->Order_Lines[] = $orderLine;
            $orderLine->setOrderNumber($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): self
    {
        if ($this->Order_Lines->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getOrderNumber() === $this) {
                $orderLine->setOrderNumber(null);
            }
        }

        return $this;
    }
}
