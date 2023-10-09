<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Repository\AuteurRepository;
use App\Repository\EmpruntRepository;
use App\Repository\EmprunteurRepository;
use App\Repository\GenreRepository;
use App\Repository\LivreRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(LivreRepository $livreRepository, AuteurRepository $auteurRepository): Response
    {
        $livres = $livreRepository->findAll();
    
        return $this->render('accueil/index.html.twig', [
            'livres' => $livres,
        ]);
    }

    #[Route('/livre/{id}', name: 'app_livre_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {   
        return $this->render('accueil/livre.show.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/genre/{id}', name: 'app_genre_show', methods: ['GET'])]
    public function genre_show(Genre $genre): Response
    {   
        return $this->render('accueil/genre.show.html.twig', [
            'genre' => $genre,
        ]);
    }

    #[Route('/auteur/{id}', name: 'app_auteur_show', methods: ['GET'])]
    public function auteur_show(Auteur $auteur): Response
    {   
        return $this->render('accueil/auteur.show.html.twig', [
            'auteur' => $auteur,
        ]);
    }

    #[Route('/emprunt', name: 'app_liste_emprunt')]
    public function liste_emprunt(EmpruntRepository $empruntRepository,EmprunteurRepository $emprunteurRepository, UserRepository $userRepository): Response
    {
        $sessionUser = $this->getUser();
        $emprunteur = $emprunteurRepository->findOneByUser($sessionUser);
        $emprunts = $empruntRepository->findByIdEmprunteur($emprunteur);
    
        return $this->render('profile/index.html.twig', [
            'emprunts' => $emprunts,
        ]);
    }
    



}
