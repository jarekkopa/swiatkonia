<?php

namespace App\Entity;

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
}
