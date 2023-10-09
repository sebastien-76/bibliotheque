<?php

namespace App\Controller;


use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Repository\EmpruntRepository;
use App\Repository\EmprunteurRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'app_profile_show', methods: ['GET'])]
    public function index(EmpruntRepository $empruntRepository,EmprunteurRepository $emprunteurRepository, UserRepository $userRepository): Response
    {
        $sessionUser = $this->getUser();
        $emprunteur = $emprunteurRepository->findOneByUser($sessionUser);
        $emprunts = $empruntRepository->findByIdEmprunteur($emprunteur);
    
        return $this->render('profile/index.html.twig', [
            'emprunts' => $emprunts,
        ]);
    }

    #[Route('/{id}', name: 'app_profile_emprunt_show', methods: ['GET'])]
    public function emprunt_show(Emprunt $emprunt, UserRepository $userRepository): Response
    {
        $sessionUser = $this->getUser();
        $emprunteur = $emprunt->getEmprunteur();
        $user = $emprunteur->getUser();
         if ($user == $sessionUser) {   
            return $this->render('profile/emprunt.show.html.twig', [
                'emprunt' => $emprunt,
            ]);
        } else {
            throw $this -> createNotFoundException();
            ;
        }
    }

}
