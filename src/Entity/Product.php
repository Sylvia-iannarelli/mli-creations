<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"product_index"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"product_index"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"product_index"})
     */
    private $picture;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Groups({"product_index"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"product_index"})
     */
    private $delivery_time;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"product_index"})
     */
    private $available;

    /**
     * @ORM\ManyToMany(targetEntity=Material::class, inversedBy="Products")
     * @Assert\NotBlank
     * @Groups({"product_index"})
     */
    private $materials;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="Products")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Groups({"product_index"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=MainColor::class, inversedBy="Products")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Groups({"product_index"})
     */
    private $mainColor;

    /**
     * @ORM\OneToMany(targetEntity=OrderLine::class, mappedBy="Product")
     */
    private $orderLines;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"product_index"})
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"product_index"})
     */
    private $Description;

    public function __construct()
    {
        $this->materials = new ArrayCollection();
        $this->orderLines = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDeliveryTime(): ?string
    {
        return $this->delivery_time;
    }

    public function setDeliveryTime(string $delivery_time): self
    {
        $this->delivery_time = $delivery_time;

        return $this;
    }

    public function getMainColor(): ?MainColor
    {
        return $this->mainColor;
    }

    public function setMainColor(?MainColor $mainColor): self
    {
        $this->mainColor = $mainColor;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }

    /**
     * @return Collection<int, Material>
     */
    public function getMaterials(): Collection
    {
        return $this->materials;
    }

    public function addMaterial(Material $material): self
    {
        if (!$this->materials->contains($material)) {
            $this->materials[] = $material;
        }

        return $this;
    }

    public function removeMaterial(Material $material): self
    {
        $this->materials->removeElement($material);

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, OrderLine>
     */
    public function getOrderLines(): Collection
    {
        return $this->orderLines;
    }

    public function addOrderLine(OrderLine $orderLine): self
    {
        if (!$this->orderLines->contains($orderLine)) {
            $this->orderLines[] = $orderLine;
            $orderLine->setProduct($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): self
    {
        if ($this->orderLines->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getProduct() === $this) {
                $orderLine->setProduct(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }
}
