<?php

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Book;
use App\Entity\DVD;
use App\Entity\Author;
use App\Entity\Ebook;
use App\Entity\CD;
use App\Entity\Document;
use App\Entity\Journal;
use App\Entity\Member;
use App\Entity\Employee;
use App\Entity\User;
use App\Entity\Borrowing;
use App\Entity\Ressources;
use App\Entity\Maintenance;
use App\Entity\Participates;
use App\Entity\IsInvolvedIn;
use App\Entity\MeetUp;
use DateTime;
use Faker;

class AppFixtures extends Fixture
{
    private $manager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->manager = $entityManager;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        $docRep = $this->manager->getRepository(Document::class);
        $userRep = $this->manager->getRepository(User::class);
        $meetUpRep = $this->manager->getRepository(MeetUp::class);
        $authorRep = $this->manager->getRepository(Author::class);
        $employeeRep = $this->manager->getRepository(Employee::class);
        $memberRep = $this->manager->getRepository(Member::class);
        
        $nbBook         = 120;
        $nbEbook        = 60;
        $nbCd           = 80;
        $nbJournal      = 20;
        $nbDvd          = 50;
        $nbAuthor       = 60;
        $nbMember       = 100;
        $nbEmployee     = 10;
        $nbMeetUp       = 20;   //doit etre inferieure à Author
        $nbRessources   = 120;
        $nbBorrowing    = 280;
        $nbParticipates = 120;
        $nbIsInvolvdIn  = 140;
        $nbMaintenance  = 40;
        $nbDocuments = $nbBook + $nbEbook + $nbCd + $nbJournal + $nbDvd;


        // on créé 100 book
        for ($i = 0; $i < $nbBook; $i++) {
            $book = new Book();
            $book->setTitle($faker->name);
            $book->setCote($faker->text($maxNbChars = 5));
            $book->setFormat($faker->randomElement($array = array('de poche', 'grand', 'moyen')));
            $book->setCodeOeuvre($faker->randomNumber($nbDigits = NULL, $strict = false));
            $book->setPages($faker->numberBetween($min = 20, $max = 500));
            $manager->persist($book);
        }
        $manager->flush();

        // on créé 100 ebook
        for ($i = 0; $i < $nbEbook; $i++) {
            $ebook = new EBook();
            $ebook->setTitle($faker->name);
            $ebook->setCote($faker->text($maxNbChars = 5));
            $ebook->setFormat($faker->randomElement($array = array('de poche', 'grand', 'moyen')));
            $ebook->setCodeOeuvre($faker->randomNumber($nbDigits = NULL, $strict = false));
            $ebook->setPages($faker->numberBetween($min = 20, $max = 500));
            $manager->persist($ebook);
        }
        $manager->flush();

        // on créé 100 cd
        for ($i = 0; $i < $nbCd; $i++) {
            $cd = new CD();
            $cd->setTitle($faker->name);
            $cd->setCote($faker->text($maxNbChars = 5));
            $cd->setFormat($faker->randomElement($array = array('audio', 'video', 'blueray')));
            $cd->setCodeOeuvre($faker->randomNumber($nbDigits = NULL, $strict = false));
            $cd->setPlages($faker->numberBetween($min = 1, $max = 100));
            $cd->setDuration($faker->dateTime($max = 'now', $timezone = null));
            $manager->persist($cd);
        }
        $manager->flush();

        // on créé 100 journal
        for ($i = 0; $i < $nbJournal; $i++) {
            $journal = new Journal();
            $journal->setTitle($faker->name);
            $journal->setCote($faker->text($maxNbChars = 5));
            $journal->setFormat($faker->randomElement($array = array('de poche', 'grand', 'moyen')));
            $journal->setCodeOeuvre($faker->randomNumber($nbDigits = NULL, $strict = false));
            $journal->setPeriodicity($faker->randomElement($array = array('1 jour', '1 semaine', '1 mois')));
            $journal->setSubscriptionDate($faker->dateTime($max = 'now', $timezone = null));
            $manager->persist($journal);
        }
        $manager->flush();

        // on créé 100 DVD
        for ($i = 0; $i < $nbDvd; $i++) {
            $dvd = new DVD();
            $dvd->setTitle($faker->name);
            $dvd->setCote($faker->text($maxNbChars = 5));
            $dvd->setFormat($faker->randomElement($array = array('audio', 'video', 'blueray')));
            $dvd->setCodeOeuvre($faker->randomNumber($nbDigits = NULL, $strict = false));
            $dvd->setDuration($faker->dateTime($max = 'now', $timezone = null));
            $manager->persist($dvd);
        }
        $manager->flush();

        // on créé 100 author
        for ($i = 0; $i < $nbAuthor; $i++) {
            $author = new Author();
            $author->setFirstName($faker->firstName($gender = 'male' | 'female'));
            $author->setLastName($faker->lastName);
            $manager->persist($author);
        }
        $manager->flush();

        // on créé 100 member
        for ($i = 0; $i < $nbMember; $i++) {
            $member = new Member();
            $member->setPseudo($faker->firstName($gender = 'male' | 'female') . $faker->lastName);
            $member->setPassword($faker->password);
            $member->setFirstName($faker->firstName($gender = 'male' | 'female'));
            $member->setLastName($faker->lastName);
            $member->setPostalCode($faker->numberBetween($min = 10000, $max = 99999));
            $member->setCity($faker->city);
            $member->setAdress($faker->address);
            $member->setMembershipDate($faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null));
            $member->setEmail($faker->freeEmail);
            $manager->persist($member);
        }
        $manager->flush();

        // on créé 100 employee
        for ($i = 0; $i < $nbEmployee; $i++) {
            $employee = new Employee();
            $employee->setPseudo($faker->firstName($gender = 'male' | 'female') . $faker->lastName);
            $employee->setFirstName($faker->firstName($gender = 'male' | 'female'));
            $employee->setLastName($faker->lastName);
            $employee->setPassword($faker->password);
            $employee->setEmail($faker->freeEmail);
            $manager->persist($employee);
        }
        $manager->flush();



            $firstAuthorId = ($authorRep->findOneBy([], ['id' => 'desc']))->getId() - ($nbAuthor);
            $firstEmployId = ($employeeRep->findOneBy([], ['id' => 'desc']))->getId() - ($nbEmployee);

        // on créé 10 meet up
        for ($i = 0; $i < $nbMeetUp; $i++) {
            $meetUp = new MeetUp();
            $meetUp->setTitle($faker->text($maxNbChars = 30));
            $meetUp->setEmployee($employeeRep->find($faker->numberBetween($min = $nbMember + 1, $max = $nbMember + $nbEmployee)));
            $firstAuthorId++;
            $meetUp->setAuthor($authorRep->find($firstAuthorId));
            $meetUp->setDate($faker->dateTimeBetween($startDate = '- 2 years', $endDate = '6 month', $timezone = null));
            $manager->persist($meetUp);
        }
        $manager->flush();

        // on créé 100 ressources
        for ($i = 0; $i < $nbRessources; $i++) {
            $ressources = new Ressources();
            $ressources->setUrl($faker->url);
            $ressources->setType($faker->randomElement($array = array('article', 'video', 'movie')));
            $ressources->setDocument($docRep->find($faker->numberBetween($min = 1, $max = $nbDocuments)));
            $manager->persist($ressources);
        }
        $manager->flush();



        // on créé 100 borrowing
        for ($i = 0; $i < $nbBorrowing; $i++) {
            $borrowing = new Borrowing();
            $startdateborrowing = $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null);
            $cloneDate = clone $startdateborrowing;
            $dateOneMonth = $cloneDate->add(new \DateInterval('P1M'));
            $borrowing->setStartDate($startdateborrowing);
            $borrowing->setExpectedReturnDate($dateOneMonth);
            $borrowing->setEffectiveReturnDate($faker->randomElement($array = array($faker->dateTimeBetween($startDate = $startdateborrowing, $endDate = '2 month', $timezone = null), NULL)));
            $borrowing->setMember($memberRep->find($faker->numberBetween($min = 1, $max = $nbMember)));
            $borrowing->setDocument($docRep->find($faker->numberBetween($min = 1, $max = $nbDocuments)));
            $manager->persist($borrowing);
        }
        $manager->flush();

        // on créé 100 participates
        for ($i = 0; $i < $nbParticipates; $i++) {
            $participates = new Participates();
            $participates->setPlaces($faker->numberBetween($min = 1, $max = 5));
            $participates->setMeetUp($meetUpRep->find($faker->numberBetween($min = 1, $max = 10)));
            $participates->setUser($userRep->find($faker->numberBetween($min = 1, $max = $nbMember)));
            $manager->persist($participates);
        }
        $manager->flush();

        // on créé 100 IsInvolvdIn
        for ($i = 0; $i < $nbIsInvolvdIn; $i++) {
            $isInvolvedIn = new IsInvolvedIn();

            $isInvolvedIn->setDocument($docRep->find($faker->numberBetween($min = 1, $max = $nbDocuments)));

            switch (get_class($isInvolvedIn->getDocument())) {
                case "App\Entity\DVD":
                    $isInvolvedIn->setRole($faker->randomElement($array = array('acteur', 'producteur', 'scénariste', 'réalisateur')));
                    break;
                case "App\Entity\CD":
                    $isInvolvedIn->setRole($faker->randomElement($array = array('chanteur', 'compositeur', 'musicien')));
                    break;
                case "App\Entity\Journal":
                    $isInvolvedIn->setRole($faker->randomElement($array = array('rédacteur', 'producteur')));
                    break;
                case "App\Entity\Book":
                    $isInvolvedIn->setRole($faker->randomElement($array = array('éditeur', 'illustrateur', 'auteur')));
                    break;
                case "App\Entity\EBook":
                    $isInvolvedIn->setRole($faker->randomElement($array = array('narrateur', 'auteur', 'illustrateur')));
                    break;
            }
            $isInvolvedIn->setAuthor($authorRep->find($faker->numberBetween($min = 1, $max = $nbAuthor)));
            $manager->persist($isInvolvedIn);
        }
        $manager->flush();

        // on créé 100 maintenance
        for ($i = 0; $i < $nbMaintenance; $i++) {
            $maintenance = new Maintenance();
            $maintenance->setStatus($faker->randomElement($array = array('à changer', 'endommagé', 'correct', 'neuf')));
            $maintenance->setMaintenanceDate($faker->dateTimeBetween($startDate = '- 2 years', $endDate = 'now', $timezone = null));
            $maintenance->setemployee($employeeRep->find($faker->numberBetween($min = $nbMember + 1, $max = $nbMember + $nbEmployee)));
            $maintenance->setDocument($docRep->find($faker->numberBetween($min = 1, $max = $nbDocuments)));
            $manager->persist($maintenance);
        }
        $manager->flush();
        
    }
}
