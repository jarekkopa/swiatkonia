<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdvertRepository")
 * @Vich\Uploadable
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

     /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName", size="imageSize")
     * 
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $imageSize;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RegionEntity", inversedBy="adverts")
     */
    private $region_id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publish_date;

    public function __toString()
    {
        return $this->getPublishDate();
    }

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

     /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(?File $image = null): void
    {
        $this->imageFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize(?int $imageSize): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    public function getRegionId(): ?RegionEntity
    {
        return $this->region_id;
    }

    public function setRegionId(?RegionEntity $region_id): self
    {
        $this->region_id = $region_id;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->is_active;
    }

    public function setActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publish_date;
    }

    public function setPublishDate(?\DateTimeInterface $publish_date): self
    {
        $this->publish_date = $publish_date;

        return $this;
    }

}
