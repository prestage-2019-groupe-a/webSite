<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    /**
     * @Route("/formations", name="formation_index")
     */
    public function index(FormationRepository $repo)
    {
        $formations = $repo->findAll();
        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/formation/{id}", name="formation_show")
     */
    public function show(Formation $formation) {
        return $this->render('formation/show.html.twig', [
            'formation'    =>  $formation
        ]);
    }
}
