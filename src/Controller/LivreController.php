<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Livre;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use App\Repository\LivreRepository;
use App\Form\LivreType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('/admin')]

 // Toutes les routes de ce controleur vont commencer par "/admin"
  
class LivreController extends AbstractController
{
    #[Route('/livre', name: 'livre')]
    #[IsGranted('ROLE_ADMIN')]
    /** 
     * @IsGranted("ROLE_ADMIN") 
     */

    public function index(LivreRepository $livreRepository): Response
    {

        /* Pour récupérer la liste de tous les livres enregistrés en bdd, je vais utiliser la classe LivreRepository.
        Les classes Repository permettent de faire de requéte SELECT sur la table correspondante
        Vous ne pouvez pas instancier un objet de la classe Repository (comme Request, EntityManager,...), il faut donc utiliser l'injection de dépendance
        C'est à dire que la classe à utiliser est passé en paramétre d'une fonction et sera instancié directement par Symfony
        
        La méthode 'findAll' récupère tous les enregistrements d'une table et retourne une liste d'objet Entity*/
        $livres = $livreRepository->findAll();
        $livreNonDisponibles = $livreRepository ->livresNonDisponibles();
        return $this->render('livre/index.html.twig', [
            'livres' => $livres,
            'livres_non_disponibles' => $livreNonDisponibles
        ]);
    }

    /**
     * @Route("/livre/ajouter", name="livre_ajouter")
     */

    #[Route('/livre/formulaire', name: 'livre_formulaire')]

    public function ajouter(Request $request, EntityManager $em)
    {
        /* dump($request) */
        if ($request->isMethod("POST")) {
            /* L'objet de la classe Request a des propriétés qui contiennent les valeurs de toutes les variables superglobales de PHP ($_GET, $_POST,...)
        Pour $_GET, la propriété 'query' 
        Pour $_POST, la propriété 'request'
        
        Ces propriétés sont des objets, avec la fonction get, je peux récupérer la valeur de l'indice demandé
        
        */


            $titre = $request->request->get("titre");
            $auteur = $request->request->get("auteur");

            $livre = new Livre;
            $livre->setTitre($titre);
            $livre->setAuteur($auteur);

            /* La classe EntityManager va permettre d'enregistrer en base de données 
    La méthode 'persit' permet de préparer une requête INSERT INTO à partir d'un objet d'une classe Entity */

            $em->persist($livre);
            /* La méthode 'flush' exécute toutes les requêtes SQL en attente : la bdd va alos être mise à jour */
            $em->flush();

            /* Pour faire une redirection vers une route existante, on utilise redirectToRoute avec le name d'une route en paramètre */
            return $this->redirectToRoute("livre");

            /* La fonction dd (dump & die) affiche un var_dump et arréte l'execution du php (fonction die) 
    dd($titre, $auteur); */
        }
        return $this->render("livre/formulaire.html.twig");
    }
    #[Route('/livre/nouveau', name: 'livre_nouveau')]


    public function nouveau(Request $request, EntityManager $em)

    {
        $livre = new Livre;
        $formLivre = $this->createForm(LivreType::class, $livre);
        /* handleRequest : permet à la variable $formlivre de gérer les informations envoyé par le navigateur */
        $formLivre->handleRequest($request);
        if ($formLivre->isSubmitted() && $formLivre->isValid()) {
            $em->persist($livre);
            $em->flush();
            return $this->redirectToRoute("livre");
        }
        return $this->render("livre/form.html.twig", ["form" => $formLivre->createView()]);
    }

    #[Route('/livre/modifier/{id}', name: 'livre_modifier', requirements: ['id' => '\d+'])]

    public function modifier(EntityManager $em, Request $request, LivreRepository $lr, $id)

    {
        $livre = $lr->find($id); /* la méthode 'find' permet de récupérer un enregistrement avec son identifiant */
        $formLivre = $this->createForm(LivreType::class, $livre);
        /* handleRequest : permet à la variable $formlivre de gérer les informations envoyé par le navigateur */
        $formLivre->handleRequest($request);
        if ($formLivre->isSubmitted() && $formLivre->isValid()) {
            /* $em->persist($livre);
            Pour modifier un enregistrement, pas besoin d'utiliser la méthode 'persist' de l'EntityManager
            Toutes les variables entités qui ont un id non nulle vont être enregistrées en bdd quand la méthode 'flush' sera appelé
            */

            $em->flush();
            return $this->redirectToRoute("livre");
        }
        return $this->render("livre/form.html.twig", ["form" => $formLivre->createView()]);
    }

    #[Route('/livre/supprimer/{id}', name: 'livre_supprimer', requirements: ['id' => '\d+'])]

    /* En passant un objet Livre comme paramétre de la méthode supprimer, $livre sera récupéré dans la base de données selon
    la valeur {id} passé dans l'URL de la route*/
    public function supprimer(EntityManager $em, Request $request, Livre $livre)
    {

        if ($request->isMethod("POST")) {
            /* La méthode 'remove()' prépare la requéte DELETE */
            $em->remove($livre);
            $em->flush();
            return $this->redirectToRoute("livre");
        }


        return $this->render("livre/supprimer.html.twig", ["livre" => $livre]);
    }
}
