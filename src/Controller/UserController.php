<?php

namespace App\Controller;

use App\Entity\UserEntity;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends Controller
{
    public function userAdd(Request $request)
    {
        $newUser = new UserEntity();
        $form = $this->createFormBuilder($newUser)
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('email', TextType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newUser);
            $entityManager->flush();

            return $this->redirectToRoute('user_add');
        }

        return $this->render('user/add.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView(),
        ]);
    }

    public function userLogin(Request $request, AuthenticationUtils $authenticationUtils) {

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', array(
            'login' => $lastUsername,
            'error' => $error,
        ));
    }
}