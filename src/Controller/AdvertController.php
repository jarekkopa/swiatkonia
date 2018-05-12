<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdvertController extends Controller
{
    public function advertAdd()
    {
        return $this->render('advert/index.html.twig', [
            'controller_name' => 'AdvertController',
        ]);
    }
}
