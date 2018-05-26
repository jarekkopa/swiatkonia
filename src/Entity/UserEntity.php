<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class UserEntity extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advert", mappedBy="user", orphanRemoval=true)
     */
    private $user_advert;

    public function __construct()
    {
        parent::__construct();
        $this->user_advert = new ArrayCollection();
        // your own logic
    }

    /**
     * @return Collection|Advert[]
     */
    public function getUserAdvert(): Collection
    {
        return $this->user_advert;
    }

    public function addUserAdvert(Advert $userAdvert): self
    {
        if (!$this->user_advert->contains($userAdvert)) {
            $this->user_advert[] = $userAdvert;
            $userAdvert->setUser($this);
        }

        return $this;
    }

    public function removeUserAdvert(Advert $userAdvert): self
    {
        if ($this->user_advert->contains($userAdvert)) {
            $this->user_advert->removeElement($userAdvert);
            // set the owning side to null (unless already changed)
            if ($userAdvert->getUser() === $this) {
                $userAdvert->setUser(null);
            }
        }

        return $this;
    }
}