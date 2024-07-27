<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    

    /**
     * @var Collection<int, UserFavoriteProduct>
     */
    #[ORM\OneToMany(targetEntity: UserFavoriteProduct::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $userFavoriteProduct;

    /**
     * @var Collection<int, CartProductOrder>
     */
    #[ORM\OneToMany(targetEntity: CartProductOrder::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $cartProductOrder;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $image = null;

    /**
     * @var Collection<int, Parts>
     */
    #[ORM\ManyToMany(targetEntity: Parts::class, mappedBy: 'product')]
    private Collection $parts;

    /**
     * @var Collection<int, ProductPartsMachine>
     */
    #[ORM\OneToMany(targetEntity: ProductPartsMachine::class, mappedBy: 'product')]
    private Collection $productPartsMachines;

    

    public function __construct()
    {
        $this->userFavoriteProduct = new ArrayCollection();
        $this->cartProductOrder = new ArrayCollection();
        $this->parts = new ArrayCollection();
        $this->productPartsMachines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    

    /**
     * @return Collection<int, UserFavoriteProduct>
     */
    public function getUserFavoriteProduct(): Collection
    {
        return $this->userFavoriteProduct;
    }

    public function addUserFavoriteProduct(UserFavoriteProduct $userFavoriteProduct): static
    {
        if (!$this->userFavoriteProduct->contains($userFavoriteProduct)) {
            $this->userFavoriteProduct->add($userFavoriteProduct);
            $userFavoriteProduct->setProduct($this);
        }

        return $this;
    }

    public function removeUserFavoriteProduct(UserFavoriteProduct $userFavoriteProduct): static
    {
        if ($this->userFavoriteProduct->removeElement($userFavoriteProduct)) {
            // set the owning side to null (unless already changed)
            if ($userFavoriteProduct->getProduct() === $this) {
                $userFavoriteProduct->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CartProductOrder>
     */
    public function getCartProductOrder(): Collection
    {
        return $this->cartProductOrder;
    }

    public function addCartProductOrder(CartProductOrder $cartProductOrder): static
    {
        if (!$this->cartProductOrder->contains($cartProductOrder)) {
            $this->cartProductOrder->add($cartProductOrder);
            $cartProductOrder->setProduct($this);
        }

        return $this;
    }

    public function removeCartProductOrder(CartProductOrder $cartProductOrder): static
    {
        if ($this->cartProductOrder->removeElement($cartProductOrder)) {
            // set the owning side to null (unless already changed)
            if ($cartProductOrder->getProduct() === $this) {
                $cartProductOrder->setProduct(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Parts>
     */
    public function getParts(): Collection
    {
        return $this->parts;
    }

    public function addPart(Parts $part): static
    {
        if (!$this->parts->contains($part)) {
            $this->parts->add($part);
            $part->addProduct($this);
        }

        return $this;
    }

    public function removePart(Parts $part): static
    {
        if ($this->parts->removeElement($part)) {
            $part->removeProduct($this);
        }

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
            $productPartsMachine->setProduct($this);
        }

        return $this;
    }

    public function removeProductPartsMachine(ProductPartsMachine $productPartsMachine): static
    {
        if ($this->productPartsMachines->removeElement($productPartsMachine)) {
            // set the owning side to null (unless already changed)
            if ($productPartsMachine->getProduct() === $this) {
                $productPartsMachine->setProduct(null);
            }
        }

        return $this;
    }

    
}
