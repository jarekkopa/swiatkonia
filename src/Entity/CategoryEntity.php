<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryEntityRepository")
 */
class CategoryEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $category_name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advert", mappedBy="adv_category", orphanRemoval=true)
     */
    private $advert_id;

    public function __construct()
    {
        $this->advert_id = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function __toString()
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): self
    {
        $this->category_name = $category_name;

        return $this;
    }

    /**
     * @return Collection|Advert[]
     */
    public function getAdvertId(): Collection
    {
        return $this->advert_id;
    }

    public function addAdvertId(Advert $advertId): self
    {
        if (!$this->advert_id->contains($advertId)) {
            $this->advert_id[] = $advertId;
            $advertId->setAdvCategory($this);
        }

        return $this;
    }

    public function removeAdvertId(Advert $advertId): self
    {
        if ($this->advert_id->contains($advertId)) {
            $this->advert_id->removeElement($advertId);
            // set the owning side to null (unless already changed)
            if ($advertId->getAdvCategory() === $this) {
                $advertId->setAdvCategory(null);
            }
        }

        return $this;
    }
}
