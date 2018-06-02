<?php

namespace App\Service;

use App\Entity\CategoryEntity;
use Doctrine\ORM\EntityManagerInterface;

class ShowCategories extends \Twig_Extension
{

   protected $em;

   public function __construct(EntityManagerInterface $em)
   {
      $this->em = $em;
    //   $this->addGlobal('categories', $this->em->getRepository(CategoryEntity::class)->findAll());
   }

   public function getCategories()
   {
      return array (
              "categories" => $this->em->getRepository(CategoryEntity::class)->findAll()
      );
   }

   public function getName()
   {
      return "CategoryEntity:ShowCategories";
   }


}