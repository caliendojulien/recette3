<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/recette", name="recette_")
 */
class RecetteController extends AbstractController
{

    /**
     * @Route("/liste", name="liste")
     */
    public function liste(
        RecetteRepository $repo,
        Request           $request
    ): Response
    {
        $tri = $request->cookies->get('tri');
        if ($tri == null) {
            $liste = $repo->findAll();
        } elseif ($tri === "favori") {
            $liste = $repo->findBy([], ["est_favori" => "DESC"]);
        } elseif ($tri === "nom") {
            $liste = $repo->findBy([], ['nom' => 'ASC']);
        }
        return $this->render('recette/liste.html.twig',
            compact("liste")
        );
    }

    /**
     * @Route("/modifiefavori/{id}", name="modifie_favori")
     */
    public function modifiefavori(
//        Recette $recette,
        int                    $id,
        RecetteRepository      $recetteRepository,
        EntityManagerInterface $em): RedirectResponse
    {
        $recette = $recetteRepository->find($id);
        $recette->setEstFavori(!$recette->getEstFavori());
        $em->persist($recette);
        $em->flush();
        return $this->redirectToRoute('recette_liste');
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function details(Recette $recette): Response
    {
        return $this->render('recette/details.html.twig',
            compact('recette')
        );
    }

    /**
     * @Route("/tri/{param}", name="tri")
     */
    public function tri(
        string            $param,
        RecetteRepository $repo,
    ): Response
    {
        if ($param == 'favori') {
            $liste = $repo->findBy([], ["est_favori" => "DESC"]);
            $cookie = new Cookie('tri', 'favori', strtotime("+1 year"));
        } else {
            $liste = $repo->findBy([], ["nom" => "ASC"]);
            $cookie = new Cookie('tri', 'nom', strtotime("+1 year"));
        }
        $response = new Response();
        $response->headers->setCookie($cookie);
        $response->send();
        return $this->render('recette/liste.html.twig',
            compact("liste")
        );
    }

}
