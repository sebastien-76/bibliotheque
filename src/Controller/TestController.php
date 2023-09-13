<?php

namespace App\Controller;


use DateTime;
use Exception;
use App\Entity\User;
use App\Entity\Genre;
use App\Entity\Auteur;
use App\Entity\Livre;
use App\Entity\Emprunteur;
use App\Entity\Emprunt;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/test')]
class TestController extends AbstractController
{
    private $hasher;

    #[Route('/user', name: 'app_test_user')]
    public function user(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        
        $title = 'Test des users';
        
        $userRepository = $em->getRepository(User::class);
        $users = $userRepository->listeUser();
        $user1 = $userRepository->find(1);
        $email = "foo.foo@example.com";
        $userFoo = $userRepository->findOneByEmail($email);
        $role = "ROLE_USER";
        $userByRole = $userRepository->findByRole($role);
        
        $userDisabled = $userRepository->findByEnabled(False);

        return $this->render('test/user.html.twig', [
            'title'=>$title,
            'users'=>$users,
            'user1'=>$user1,
            'userFoo'=>$userFoo,
            'userByRole'=>$userByRole,
            'userDisabled'=>$userDisabled,
            'actif'=> 'Actif',
            'inactif'=>'Inactif',

        ]);
    }

    #[Route('/livre', name: 'app_test_livre')]
    public function livre(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $livreRepository = $em->getRepository(Livre::class);
        //Récupération du repository Auteur
        $auteurRepository = $em->getRepository(Auteur::class);
        //Récupération du repository Genre
        $genreRepository = $em->getRepository(Genre::class);
        
        $title = 'Test des livres';
        
        // Création d'un nouveau livre

        // Récupération de l'auteur 2
        $auteur2 = $auteurRepository->find(2);
        // Récupération du genre 6
        $genre6 = $genreRepository->find(6);

        $nouveauLivre = new Livre;
        $nouveauLivre->setTitre('Totum autem id externum');
        $nouveauLivre->setAnneeEdition('2020');
        $nouveauLivre->setNombrePages('300');
        $nouveauLivre->setCodeIsbn('9790412882714');
        $nouveauLivre->setAuteur($auteur2);
        $nouveauLivre->addGenre($genre6);

        $em->persist($nouveauLivre);

        try {
            $em->flush();
        } catch(Exception $e) {
            //gère l'erreur
            dump($e->getMessage());
        }

        $livres = $livreRepository->listeLivre();
        $livre1 = $livreRepository->find(1);
        $livresLorem = $livreRepository->findBykeyword('lorem');
        //Recherche des livres dont l'auteur a l'ID 2 ( dont le livre ajouté ci-dessus)
        $livresAuteurId = $livreRepository->findByAuteurId('2');
        //Recherche des livres dont le genre contient roman
        $livresGenre = $livreRepository->findByGenre('roman');

        // Modification du livre dont l'id est 2

        //Récupération des infos du livre dont l'id est 2
        $livre2 = $livreRepository->find(2);
        //Récupération du genre 5
        $genre5 = $genreRepository->find(5);
        
        //Modification des informations titre et genre
        $livre2->setTitre('Aperiendum est igitur');
        // Suppression de l'ancien genre et ajout du nouveau genre
        // Données statiques définies, on sait qu'il n'y a qu'un seul genre
        $ancienGenre = $livre2->getGenres();
        $livre2->removeGenre($ancienGenre[0]);
        $livre2->addGenre($genre5);

        $em->flush();

        //suppression du livre dont l'id est 123
        $livre123 = $livreRepository->find(123);
        if ($livre123) {
            // Suppression de l'objet seulement s'il existe
            $em->remove($livre123);
            $em->flush();
        }
    
        return $this->render('test/livre.html.twig', [
            'title'=>$title,
            'livres'=>$livres,
            'livre1'=>$livre1,
            'livresLorem'=>$livresLorem,
            'livresAuteurId'=>$livresAuteurId,
            'livresGenre'=>$livresGenre,
        ]);
    }

    #[Route('/emprunteur', name: 'app_test_emprunteur')]
    public function emprunteur(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $emprunteurRepository = $em->getRepository(Emprunteur::class);

        $title = 'Test des emprunteurs';

        $emprunteurs = $emprunteurRepository->listeEmprunteur();
        $emprunteur3 = $emprunteurRepository->find(3);
        $emprunteurByUserId = $emprunteurRepository->findOneByUserId(3);
        $emprunteurByKeyword = $emprunteurRepository->findByKeyword('foo');
        $emprunteurByTel = $emprunteurRepository->findByTel('1234');
        $emprunteurByCreatedAt = $emprunteurRepository->findByCreatedAt('2021-03-01 00:00:00');

        return $this->render('test/emprunteur.html.twig', [
            'title'=>$title,
            'emprunteurs'=>$emprunteurs,
            'emprunteur3'=>$emprunteur3,
            'emprunteurByUserId'=>$emprunteurByUserId,
            'emprunteurByKeyword'=>$emprunteurByKeyword,
            'emprunteurByTel'=>$emprunteurByTel,
            'emprunteurByCreatedAt'=>$emprunteurByCreatedAt,
        ]);
    
    }

    #[Route('/emprunt', name: 'app_test_emprunt')]
    public function emprunt(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $empruntRepository = $em->getRepository(Emprunt::class);
        $emprunteurRepository = $em->getRepository(Emprunteur::class);
       
        $emprunteur1 = $emprunteurRepository->find(1);
        $livreRepository = $em->getRepository(Livre::class);
        $livre1 = $livreRepository->find(1);

       
        $title = 'Test des emprunts';

        //Création d'un nouvel emprunt
        $nouvelEmprunt = new Emprunt;
        $nouvelEmprunt->setDateEmprunt(new Datetime('2020-12-01 16:00:00'));
        $nouvelEmprunt->setDateRetour(null);
        $nouvelEmprunt->setLivre($livre1);
        $nouvelEmprunt->setEmprunteur($emprunteur1);

        $em->persist($nouvelEmprunt);

        try {
            $em->flush();
        } catch(Exception $e) {
            //gère l'erreur
            dump($e->getMessage());
        }

        //Modification de la date de retour de l'emprunt id 3
        $emprunt3 = $empruntRepository->find(3);
        $emprunt3->setDateRetour(new Datetime('2020-05-01 10:00:00'));

        $em->flush();

        //Suppression de l'emprunt id 42
        $emprunt42 = $empruntRepository->find(42);
        if ($emprunt42) {
            // Suppression de l'objet seulement s'il existe
            $em->remove($emprunt42);
            $em->flush();
        }
        
        //Lecture des différentes données

        $emprunt1 = $empruntRepository->find(1);
        $empruntByDateEmprunt = $empruntRepository->findByDateEmprunt();
        $empruntIdEmpunteur2 = $empruntRepository->findByIdEmprunteur(2);
        $empruntIdLivre3 = $empruntRepository->findByIdLivre(3);
        $empruntByDateRetour = $empruntRepository->findByDateRetour();
        $empruntByNonRetour = $empruntRepository->findByNonRetour();


        return $this->render('test/emprunt.html.twig', [
            'title'=>$title,
            'empruntByDateEmprunt'=>$empruntByDateEmprunt,
            'empruntIdEmpunteur2'=>$empruntIdEmpunteur2,
            'empruntIdLivre3'=>$empruntIdLivre3,
            'empruntByDateRetour'=>$empruntByDateRetour,
            'empruntByNonRetour'=>$empruntByNonRetour,
        ]); 

    }
}
