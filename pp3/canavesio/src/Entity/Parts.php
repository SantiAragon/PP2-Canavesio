<?php

namespace App\Entity;

use App\Repository\PartsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartsRepository::class)]
class Parts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'parts')]
    private Collection $product;

    /**
     * @var Collection<int, ProductPartsMachine>
     */
    #[ORM\OneToMany(targetEntity: ProductPartsMachine::class, mappedBy: 'parts')]
    private Collection $productPartsMachines;

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->productPartsMachines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->product->contains($product)) {
            $this->product->add($product);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        $this->product->removeElement($product);

        return $this;
    }

    /**
     * @return Collection<int, ProductPartsMachine>
     */
    public function getProductPartsMachines(): Collection
    {
        return $this->productPartsMachines;
    }

    public function addProductPartsMachine(ProductPartsMachine $productPartsMachine): static
    {
        if (!$this->productPartsMachines->contains($productPartsMachine)) {
            $this->productPartsMachines->add($productPartsMachine);
            $productPartsMachine->setParts($this);
        }

        return $this;
    }

    public function removeProductPartsMachine(ProductPartsMachine $productPartsMachine): static
    {
        if ($this->productPartsMachines->removeElement($productPartsMachine)) {
            // set the owning side to null (unless already changed)
            if ($productPartsMachine->getParts() === $this) {
                $productPartsMachine->setParts(null);
            }
        }

        return $this;
    }
}
