<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\{Advert};

class CategoryController extends Controller
{
    // wyświetla ogłoszenia z danej kategorii
    public function showCategoryAllAdverts($id)
    {
        $categoryAdverts = $this->getDoctrine()->getRepository(Advert::class)->findBy(['adv_category' => $id]);

        return $this->render('category/show_all_category_adverts.html.twig', [
            'adverts' => $categoryAdverts,
        ]);
    }
}
