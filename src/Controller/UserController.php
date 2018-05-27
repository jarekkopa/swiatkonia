<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\UserEntity;

class UserController extends Controller
{
    // /**
    //  * @Route("/user", name="user")
    //  */
    // public function deleteUser()
    // {
    //     return $this->render('user/delete_user.html.twig', [
    //         'controller_name' => 'UserController',
    //     ]);
    // }

    public function deleteUser($id)
    {
        $user = $this->getDoctrine()->getRepository(UserEntity::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('fos_user_security_logout');
    }
}
