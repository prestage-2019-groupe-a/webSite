<?php

namespace App\Controller;

use App\Repository\FormationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(FormationRepository $repo)
    {
        return $this->render('home/index.html.twig', [

            'formations' => $repo->findBestFormations(3)
        ]);
    }
}
