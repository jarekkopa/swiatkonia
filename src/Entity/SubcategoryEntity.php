<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubcategoryEntityRepository")
 */
class SubcategoryEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subcategoryName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoryEntity", inversedBy="subcategoryEntities")
     */
    private $categoryId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advert", mappedBy="subcategory")
     */
    private $adverts;

    public function __construct()
    {
        $this->adverts = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSubcategoryName(): ?string
    {
        return $this->subcategoryName;
    }

    public function setSubcategoryName(?string $subcategoryName): self
    {
        $this->subcategoryName = $subcategoryName;

        return $this;
    }

    public function getCategoryId(): ?CategoryEntity
    {
        return $this->categoryId;
    }

    public function setCategoryId(?CategoryEntity $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * @return Collection|Advert[]
     */
    public function getAdverts(): Collection
    {
        return $this->adverts;
    }

    public function addAdvert(Advert $advert): self
    {
        if (!$this->adverts->contains($advert)) {
            $this->adverts[] = $advert;
            $advert->setSubcategory($this);
        }

        return $this;
    }

    public function removeAdvert(Advert $advert): self
    {
        if ($this->adverts->contains($advert)) {
            $this->adverts->removeElement($advert);
            // set the owning side to null (unless already changed)
            if ($advert->getSubcategory() === $this) {
                $advert->setSubcategory(null);
            }
        }

        return $this;
    }
}
