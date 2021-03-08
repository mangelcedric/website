<?php

namespace App\Controller;

use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    /**
     * @Route("/competences", name="competences")
     */
    public function index(SkillRepository $skillRepository): Response
    {
        return $this->render('competences/index.html.twig', [
            'skills' => $skillRepository->findAll(),
        ]);
    }
}
