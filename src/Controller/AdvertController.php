<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\{Advert, CategoryEntity};
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType};
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AdvertController extends Controller
{
    public function advertAdd(Request $request)
    {
        $category = new Advert(); // tworzę obikt na bazie encji Advert - mam dzięki temu dostęp do wszystkich pól tej encji

        // do zmiennej form przypisuję mój cały formularz
        $form = $this->CreateFormBuilder($category) // wywołuję FormBuilder'a, który odpowiada za generowanie formularza
        ->add('adv_title', TextType::class) // generuję pole tekstowe
        ->add('adv_description', TextType::class) // generuję pole tekstowe
        ->add('price', TextType::class) // generuję pole tekstowe
        ->add('adv_category', EntityType::class, [ // tu przypisuję do pola USER z encji CommentEntity dane z innej encji (UserEntity)
            'class' => CategoryEntity::class, // robię to tutaj (jako parametr) - czyli...do pola user z ComemntEnity podpinam cały obiekt UserEntity
        ])
        ->add('send', SubmitType::class) // generuję przycisk submit
        ->getForm(); // generuję formularz
    
        $form->handleRequest($request); // do mojego formularza podpinam teraz metodę request, która w parametrze pobierze wszystkie dane jakie podano w formularzu
    
        if ($form->isSubmitted() && $form->isValid()) { // sprawdzam czy wysłano formularz i czy pola przeszły walidację
            $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category); // dodaję do pamięci - coś jak commit. Można zrobić wiele commitów
        $entityManager->flush(); // przesyłam dane do bazy - działa jak push
        return $this->redirectToRoute('advert_add'); // żeby nie wywalało błędu daję redirect do strony głównej
        }

        return $this->render('advert/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
