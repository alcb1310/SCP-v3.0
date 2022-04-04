<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersApiController extends AbstractController
{
    #[Route('/api/users')]
    public function getUserData(Request $request, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['username' => $request->query->get('username')]);

        $userData = array();
        $userData['username'] = $user->getUsername();
        $userData['nombre'] = $user->getNombre();

        return new JsonResponse($userData);
    }

}
