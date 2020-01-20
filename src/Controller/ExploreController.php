<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExploreController extends AbstractController
{
    
    /**
     * @Route("/explore", name="explore")
     */
    public function index(UserRepository $userRepository)
    {

        return $this->render('explore/accueil.html.twig', [
            'controller_name' => 'ExploreController',
             'users' => $userRepository->findAll(),
        ]);
    }

}
