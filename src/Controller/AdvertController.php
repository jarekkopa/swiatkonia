<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\{Advert, CategoryEntity, UserEntity, RegionEntity};
use App\Form\Type\CategoryType;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType, FileType};
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AdvertController extends Controller
{

//METODA WYŚWIETLAJĄCA OGŁOSZENIA Z DB NA STRONIE GŁÓWNEJ
    public function index()
    {
        // pobranie ogłoszen
        $adverts = $this->getDoctrine()->getRepository(Advert::class)->findAll(); 

        // pobranie kategorii menu
        $categories = $this->getDoctrine()->getRepository(CategoryEntity::class)->findAll();

        return $this->render('advert/show_all_adverts.html.twig', [
            'advert' => $adverts,
            'categories' => $categories]); 

    }

// METODA DODAJĄCA OGŁOSZENIE DO DB
    public function advertAdd(Request $request)
    {
        
        $advert = new Advert(); // tworzę obikt na bazie encji Advert - mam dzięki temu dostęp do wszystkich pól tej encji

        // do zmiennej form przypisuję mój cały formularz
        $form = $this->CreateFormBuilder($advert) // wywołuję FormBuilder'a, który odpowiada za generowanie formularza
        ->add('adv_title', TextType::class) // generuję pole tekstowe
        ->add('adv_description', TextType::class) // generuję pole tekstowe
        ->add('price', TextType::class) // generuję pole tekstowe
        ->add('imageFile', FileType::class) 
        ->add('adv_category', EntityType::class, [ 
            'class' => CategoryEntity::class, 
        ])

        // ->add('adv_category', CategoryType::class)

        ->add('region_id', EntityType::class, [ 
            'class' => RegionEntity::class, 
        ])
        ->add('send', SubmitType::class) // generuję przycisk submit
        ->getForm(); // generuję formularz
    
        $form->handleRequest($request); // do mojego formularza podpinam teraz metodę request, która w parametrze pobierze wszystkie dane jakie podano w formularzu
    
        if ($form->isSubmitted() && $form->isValid()) { // sprawdzam czy wysłano formularz i czy pola przeszły walidację
            $entityManager = $this->getDoctrine()->getManager();
            $advert->setUser($this->getUser()); // WAŻNE - tutaj dodaje do
            $advert->setActive(true);
            $advert->setPublishDate(new \DateTime('now'));
        $entityManager->persist($advert); // dodaję do pamięci - coś jak commit. Można zrobić wiele commitów
        $entityManager->flush(); // przesyłam dane do bazy - działa jak push
        return $this->redirectToRoute('index'); // żeby nie wywalało błędu daję redirect do strony głównej
        }

        return $this->render('advert/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // METODA WYŚWIETLAJĄCA OGŁOSZENIE O PODANYM ID
    public function advertShowId($id)
    {
        $advert = $this->getDoctrine()->getRepository(Advert::class)->find($id);

        return $this->render('advert/showid.html.twig', [
            'adv' => $advert,
        ]);
    }

    // METODA UMOŻLIWIAJĄCA EDYCJĘ OGŁOSZENIA O DANYM ID
    public function advertEdit($id, Request $request)
    {
        $advert = $this->getDoctrine()->getRepository(Advert::class)->find($id); // pobieram o głoszenie o danym ID

        $form = $this->CreateFormBuilder($advert)
        ->add('adv_title', TextType::class)
        ->add('adv_description', TextType::class)
        ->add('price', TextType::class)
        ->add('imageFile', FileType::class) 
        ->add('adv_category', EntityType::class, [
            'class' => CategoryEntity::class,
        ])
        ->add('region_id', EntityType::class, [ 
            'class' => RegionEntity::class, 
        ])
        ->add('send', SubmitType::class)
        ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $advert->setUser($this->getUser());
            $entityManager->persist($advert);
            $entityManager->flush();
            return $this->redirectToRoute('index'); 
        }

        return $this->render('advert/editid.html.twig', [
            'form' => $form->createView(),
            'adv' => $advert
        ]);
    }

    public function showMyAdverts()
    {

        $adverts = $this->getDoctrine()->getRepository(Advert::class)->findBy(array('user'=>$this->getUser()));

        return $this->render('advert/showmyadverts.html.twig', [
            'advert' => $adverts,
        ]); 
    }

    // METODA USUWAJĄCA OGŁOSZENIE Z BAZY PO KLIKNIĘCIU PRZEZ UŻYTKOWNIKA
    public function advertRemove($id)
    {
        $advert = $this->getDoctrine()->getRepository(Advert::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($advert);
        $entityManager->flush();
        return $this->redirectToRoute('user_adverts');
    }

    public function advertActivate($id)
    {
        $advert = $this->getDoctrine()->getRepository(Advert::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $advert->setActive(true);
        $entityManager->persist($advert);
        $entityManager->flush();
        return $this->redirectToRoute('user_adverts');
    }

    public function advertDeactivate($id)
    {
        $advert = $this->getDoctrine()->getRepository(Advert::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $advert->setActive(false);
        $entityManager->persist($advert);
        $entityManager->flush();
        return $this->redirectToRoute('user_adverts');
    }

}
