<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'recherche')]

    public function index(Request $rq, LivreRepository $lr): Response
    {
        /* 1 - récuperez le mot tapé dans le formulaire de recherche
   2 - affichez : "Résultat pour la recherche de : ..."
*/
        $mot = $rq->query->get("mot");
        $livres = $lr->findByMot($mot);
        /* Compact() va créer un tableau avec les paramétres qui lui sont passés :
compact("nom","prenom") va retourner le tableau :

    [
    "nom"* => $nom,
    "prenom", $prenom
    ]
    il faut que les variables $nom et $prenom existent  
    */
        return $this->render(
            'recherche/index.html.twig',
            compact("mot", $livres)

        );
    }
}
