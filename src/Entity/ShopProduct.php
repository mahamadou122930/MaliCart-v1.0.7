<?php

namespace App\Entity;

use App\Repository\ShopProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ShopProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('slug', message: 'Ce slug existe déja.')]
class ShopProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $subtitle = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 5)]
    #[Assert\Regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', message: 'Invalid slug')]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration2 = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration3 = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration4 = null;

    #[ORM\Column]
    private ?bool $statut = null;

    #[ORM\ManyToOne(inversedBy: 'shopProducts')]
    private ?ShopProductSubCategory $SubCategory = null;

    #[ORM\ManyToMany(targetEntity: ShopProductColor::class, inversedBy: 'shopProducts')]
    private Collection $color;

    #[ORM\ManyToMany(targetEntity: ShopProductSize::class, inversedBy: 'shopProducts')]
    private Collection $size;

    #[ORM\ManyToOne(inversedBy: 'shopProducts')]
    private ?ShopProductBrand $Brand = null;


    public function __construct()
    {
        $this->color = new ArrayCollection();
        $this->size = new ArrayCollection();
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

    public function __toString()
    {
        return $this->getName();
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getIllustration2(): ?string
    {
        return $this->illustration2;
    }

    public function setIllustration2(string $illustration2): self
    {
        $this->illustration2 = $illustration2;

        return $this;
    }

    public function getIllustration3(): ?string
    {
        return $this->illustration3;
    }

    public function setIllustration3(string $illustration3): self
    {
        $this->illustration3 = $illustration3;

        return $this;
    }

    public function getIllustration4(): ?string
    {
        return $this->illustration4;
    }

    public function setIllustration4(string $illustration4): self
    {
        $this->illustration4 = $illustration4;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getSubCategory(): ?ShopProductSubCategory
    {
        return $this->SubCategory;
    }

    public function setSubCategory(?ShopProductSubCategory $SubCategory): self
    {
        $this->SubCategory = $SubCategory;

        return $this;
    }

    /**
     * @return Collection<int, ShopProductColor>
     */
    public function getColor(): Collection
    {
        return $this->color;
    }

    public function addColor(ShopProductColor $color): self
    {
        if (!$this->color->contains($color)) {
            $this->color->add($color);
        }

        return $this;
    }

    public function removeColor(ShopProductColor $color): self
    {
        $this->color->removeElement($color);

        return $this;
    }

    /**
     * @return Collection<int, ShopProductSize>
     */
    public function getSize(): Collection
    {
        return $this->size;
    }

    public function addSize(ShopProductSize $size): self
    {
        if (!$this->size->contains($size)) {
            $this->size->add($size);
        }

        return $this;
    }

    public function removeSize(ShopProductSize $size): self
    {
        $this->size->removeElement($size);

        return $this;
    }

    public function getBrand(): ?ShopProductBrand
    {
        return $this->Brand;
    }

    public function setBrand(?ShopProductBrand $Brand): self
    {
        $this->Brand = $Brand;

        return $this;
    }

    

    
}
