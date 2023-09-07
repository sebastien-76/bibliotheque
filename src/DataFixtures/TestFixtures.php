<?php

namespace App\DataFixtures;


use DateTime;
use App\Entity\Auteur;
use App\Entity\Emprunt;
use App\Entity\Emprunteur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TestFixtures extends Fixture implements FixtureGroupInterface
{
    private $faker;
    private $hasher;
    private $manager;

    public function __construct(UserPasswordHasherInterface $hasher)
        {
            $this->faker = FakerFactory::create('fr_FR');
            $this->hasher = $hasher;

        }
    
        public static function getGroups(): array
        {
            return ['test'];
        }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->loadAuteurs();
        $this->loadGenres();
        $this->loadLivres();
        $this->loadEmprunteurs();
        $this->loadEmprunts();
    }

    public function loadGenres(): void
    {
        //Données statiques
        $datas = [
            [
                'nom' => 'poésie',
                'description' => null,
            ],
            [
                'nom' => 'nouvelle',
                'description' => null,
            ],
            [
                'nom' => 'roman historique',
                'description' => null,
            ],
            [
                'nom' => 'roman d\'amour',
                'description' => null,
            ],
            [
                'nom' => 'roman d\'aventure',
                'description' => null,
            ],
            [
                'nom' => 'sciences-fiction',
                'description' => null,
            ],
            [
                'nom' => 'fantasy',
                'description' => null,
            ],
            [
                'nom' => 'biographie',
                'description' => null,
            ],
            [
                'nom' => 'conte',
                'description' => null,
            ],
            [
                'nom' => 'témoignage',
                'description' => null,
            ],
            [
                'nom' => 'théâtre',
                'description' => null,
            ],
            [
                'nom' => 'essai',
                'description' => null,
            ],
            [
                'nom' => 'journal intime',
                'description' => null,
            ],
        ];
    
        foreach ($datas as $data) {
            $genre = new Genre();
            $genre->setNom($data['nom']);
            $genre->setDescription($data['description']);

            $this->manager->persist($genre);
        }

        $this->manager->flush();

        // aucunes données dynamiques
    }

    public function loadAuteurs(): void
    {
        //Données statiques
        $datas = [
            [
                'nom' => 'auteur inconnu',
                'prénom' => '',
            ],
            [
                'nom' => 'Cartier',
                'prénom' => 'Hugues',
            ],
            [
                'nom' => 'Lambert',
                'prénom' => 'Armand',
            ],
            [
                'nom' => 'Moitessier',
                'prénom' => 'Thomas',
            ],
        ];
    
        foreach ($datas as $data) {
            $auteur = new Auteur();
            $auteur->setNom($data['nom']);
            $auteur->setPrenom($data['prénom']);

            $this->manager->persist($auteur);
        }

        $this->manager->flush();

        // données dynamiques
        for ($i = 0; $i <500; $i++) {
            $auteur = new Auteur();
            $auteur->setNom($this->faker->LastName());
            $auteur->setPrenom($this->faker->FirstName());

        $this->manager->persist($auteur);
        }

        $this->manager->flush();

    }

    public function loadEmprunteurs(): void
    {
        //données statiques
        $data = [
            [
                'email' => 'foo.foo@example.com',
                'role' => ['ROLE_USER'],
                'password' => '123',
                'enabled' => true,
                'nom' => 'foo',
                'prénom' => 'foo',
                'tel' => '123456789',
            ],
            [
                'email' => 'bar.bar@example.com',
                'role' => ['ROLE_USER'],
                'password' => '123',
                'enabled' => false,
                'nom' => 'bar',
                'prénom' => 'bar',
                'tel' => '123456789',
            ],
            [
                'email' => 'baz.baz@example.com',
                'role' => ['ROLE_USER'],
                'password' => '123',
                'enabled' => true,
                'nom' => 'baz',
                'prénom' => 'baz',
                'tel' => '123456789',
            ],
        ];
        
        foreach ($data as $data) {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setRoles($data['role']);
            $password = $this ->hasher->hashPassword($user, $data['password']);
            $user->setPassword($password);
            $user->setEnabled($data['enabled']);

            $this->manager->persist($user);

            $emprunteur = new Emprunteur();
            $emprunteur->setNom($data['nom']);
            $emprunteur->setPrenom($data['prénom']);
            $emprunteur->setTel($data['tel']);
            $emprunteur->setUser($user);
            
        $this->manager->persist($emprunteur);
        }
        
        $this->manager->flush();

        //données dynamiques

        for ($i = 0; $i <100; $i++) {
            $user = new User();
            $user->setEmail($this->faker->unique()->safeEmail());
            $user->setRoles(['ROLE_USER']);
            $password = $this ->hasher->hashPassword($user, '123');
            $user->setPassword($password);
            $user->setEnabled($this->faker->boolean(70));

            $this->manager->persist($user);
         
            $emprunteur = new Emprunteur();
            $emprunteur->setNom($this->faker->lastName());
            $emprunteur->setPrenom($this->faker->firstName());
            $emprunteur->setTel($this->faker->phoneNumber());
            $emprunteur->setUser($user);


            $this->manager->persist($emprunteur);
        }

    $this->manager->flush();

    }

    public function loadLivres(): void
    {
        //Données statiques
        //Récupération du repo des auteurs
        $auteurRepository = $this->manager->getRepository(Auteur::class);
        $auteurs = $auteurRepository->findAll();
        $auteur1 = $auteurRepository->find(1);
        $auteur2 = $auteurRepository->find(2);
        $auteur3 = $auteurRepository->find(3);
        $auteur4 = $auteurRepository->find(4);

        //Récupération du repo des genres
        $genreRepository = $this->manager->getRepository(Genre::class);
        $genres = $genreRepository->findAll();
        $genre1 = $genreRepository->find(1);
        $genre2 = $genreRepository->find(2);
        $genre3 = $genreRepository->find(3);
        $genre4 = $genreRepository->find(4);

        $datas = [
            [
                'titre' => 'Lorem ipsum dolor sit amet',
                'anneeEdition' => '2010',
                'nombrePages' => '100',
                'codeIsbn' => '9785786930024',
                'auteur' => $auteur1,
                'genres' => [$genre1],
            ],
            [
                'titre' => 'Consectetur adipiscing elit',
                'anneeEdition' => '2011',
                'nombrePages' => '150',
                'codeIsbn' => '9783817260935',
                'auteur' => $auteur2,
                'genres' => [$genre2],
            ],
            [
                'titre' => 'Mihi quidem Antiochum',
                'anneeEdition' => '2012',
                'nombrePages' => '200',
                'codeIsbn' => '9782020493727',
                'auteur' => $auteur3,
                'genres' => [$genre3],
            ],
            [
                'titre' => 'Quem audis satis belle',
                'anneeEdition' => '2013',
                'nombrePages' => '250',
                'codeIsbn' => '9794059561353',
                'auteur' => $auteur4,
                'genres' => [$genre4],
            ],
        ];
    
        foreach ($datas as $data) {
            $livre = new Livre();
            $livre->setTitre($data['titre']);
            $livre->setAnneeEdition($data['anneeEdition']);
            $livre->setNombrePages($data['nombrePages']);
            $livre->setCodeIsbn($data['codeIsbn']);
            $livre->setAuteur($data['auteur']);
        //            $livre->addGenre($data['genres'][0]);

            foreach ($data['genres'] as $genre) {
                $livre->addGenre($genre);
            }

            $this->manager->persist($livre);
        }

        $this->manager->flush();

        // données dynamiques
        for ($i = 0; $i <1000; $i++) {
            $livre  = new livre();
            $words = random_int(2, 5);
            $livre->setTitre($this->faker->sentence($words));
            $livre->setAnneeEdition($this->faker->year());
            $livre->setNombrePages($this->faker->randomNumber(3, true));
            $livre->setCodeIsbn($this->faker->isbn13());
            $auteur = $this->faker->randomElement($auteurs);
            $livre->setAuteur($auteur);
            $nombreGenre = random_int(1, 3);
            $shortList = $this->faker->randomElements($genres, $nombreGenre);
            foreach ($shortList as $genre) {
                $livre->addGenre($genre);
            }

        $this->manager->persist($livre);
        }

        $this->manager->flush();

    }
    
    public function loadEmprunts(): void
    {
        //Données statiques
        $emprunteurRepository = $this->manager->getRepository(Emprunteur::class);
        $emprunteurs = $emprunteurRepository->findAll();
        $emprunteur1 = $emprunteurRepository->find(1);
        $emprunteur2 = $emprunteurRepository->find(2);
        $emprunteur3 = $emprunteurRepository->find(3);

        $livreRepository = $this->manager->getRepository(Livre::class);
        $livres = $livreRepository->findall();
        $livre1 = $livreRepository->find(1);
        $livre2 = $livreRepository->find(2);
        $livre3 = $livreRepository->find(3);

        $datas = [
            [
                'dateEmprunt' => new DateTime('2020-02-01 10:00:00'),
                'dateRetour' => new DateTime('2020-03-01 10:00:00'),
                'emprunteurId' => $emprunteur1,
                'livreId' => [$livre1],
            ],
            [
                'dateEmprunt' => new DateTime('2020-03-01 10:00:00'),
                'dateRetour' => new DateTime('2020-04-01 10:00:00'),
                'emprunteurId' => $emprunteur2,
                'livreId' => [$livre2],
            ],
            [
                'dateEmprunt' => new DateTime('2020-04-01 10:00:00'),
                'dateRetour' => null,
                'emprunteurId' => $emprunteur3,
                'livreId' => [$livre3],
            ],
        ];
    
        foreach ($datas as $data) {
            $emprunt = new Emprunt();
            $emprunt->setDateEmprunt($data['dateEmprunt']);
            $emprunt->setDateRetour($data['dateRetour']);
            $emprunt->setLivre($data['livreId'][0]);
            $emprunt->setEmprunteur($data['emprunteurId']);

            $this->manager->persist($emprunt);
            }

        $this->manager->flush();
        
        // données dynamiques
        for ($i = 0; $i <200; $i++) {
            $emprunt = new Emprunt();
            $emprunt->setDateEmprunt($this->faker->datetimebetween('-1year','-5months'));
            $emprunt->setDateRetour($this->faker->datetimebetween('-5months','-1day'));
            $livre = $this->faker->randomElement($livres);
            $emprunt->setLivre($livre);
            $emprunteur = $this->faker->randomElement($emprunteurs);
            $emprunt->setEmprunteur($emprunteur);

        $this->manager->persist($emprunt);
        }

        $this->manager->flush();

    }
}
