<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * Ce commentaires s'appellent annotations. Ils commencent par /**, il ne doit rien y avoir
     * 
     * après. Chaque ligne doit commencer par * 
     * 
     * Toutes les méthodes d'un controlleur (qui correpondent à une route) 
     * doivent retourner un objet de la classe Response
     * 
     * */

    #[Route('/test', name: 'test')]

    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }


    #[Route('/test/accueil', name: 'test_accueil')]


    public function accueil()
    {
        $nombre = 45;
        $prenom = "Roger";
        return $this->render("base.html.twig", ["nombre" => $nombre, "prenom" => $prenom]);
    }

    #[Route('/test/heritage')]


    public function heritage()
    {
        return $this->render("test/heritage.html.twig");
    }

    #[Route('/test/transitif')]


    public function transitif()
    {
        return $this->render("test/transitif.html.twig");
    }

    #[Route('/test/tableau')]


    public function tableau()
    {
        $tab= ["jour" => "07", "mois" => "mai", "annee" => "2021"];

        return $this->render("test/variable.html.twig", ["tableau" => $tab,
        "tableau2" => [45,"test", true],
        "nombre" => 0,
        "chaine" => ""

        ]);
    }

    #[Route('/test/salutation/{prenom}')]

    public function salutation($prenom)
    {

        return $this->render("test/salutation.html.twig", ["prenom" => $prenom ]);

        /* * EXO : créez une nouvelle route qui va prendre
     *  2 paramètres dans l'url et qui va affichez la 
     * valeur de l'addition, la multiplication, la soustraction
     * et la division des 2 nombres passés en paramètres
     * 
     * Si le 2ième paramètres est 0, il ne faut pas afficher
     * le résultat de la division (affichez "Division par 0 impossible")
 */
    }

}
