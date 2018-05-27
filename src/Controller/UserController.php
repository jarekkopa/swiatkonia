<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\UserEntity;

class UserController extends Controller
{
    public function deleteUser($id)
    {
        $user = $this->getDoctrine()->getRepository(UserEntity::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('fos_user_security_logout');
    }
}
