<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LivreRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(LivreRepository $lr): Response
    {


        return $this->render('home/index.html.twig', [
            'livres' => $lr->findAll(),
            'livres_non_disponibles' => $lr->livresNonDisponibles()

        ]);
    }
}
