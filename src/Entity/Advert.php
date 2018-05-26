<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdvertRepository")
 */
class Advert
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adv_title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adv_description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoryEntity", inversedBy="advert_id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adv_category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserEntity", inversedBy="user_advert")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    public function getId()
    {
        return $this->id;
    }

    public function getAdvTitle(): ?string
    {
        return $this->adv_title;
    }

    public function setAdvTitle(string $adv_title): self
    {
        $this->adv_title = $adv_title;

        return $this;
    }

    public function getAdvDescription(): ?string
    {
        return $this->adv_description;
    }

    public function setAdvDescription(?string $adv_description): self
    {
        $this->adv_description = $adv_description;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAdvCategory(): ?CategoryEntity
    {
        return $this->adv_category;
    }

    public function setAdvCategory(?CategoryEntity $adv_category): self
    {
        $this->adv_category = $adv_category;

        return $this;
    }

    public function getUser(): ?UserEntity
    {
        return $this->user;
    }

    public function setUser(?UserEntity $user): self
    {
        $this->user = $user;

        return $this;
    }

}
