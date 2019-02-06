<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Coach;
use App\Entity\Comment;
use App\Entity\Student;
use App\Entity\Exercice;
use App\Entity\Formation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $faker;
    private $encoder;
    private $listUser;
    private $listStudent;
    private $listCoach;
    private $listExercice;

    public function __construct(UserPasswordEncoderInterface $encoder) {

        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create('fr-FR');

        $this->listUser = [];
        $this->listStudent = [];
        $this->listCoach = [];
        $this->listFormation = [];
        $this->listExercice = [];

        $this->createUser("Egan", "Lecocq", "e.lecocq@students.ephec.be")
             ->createUser("Guillaume", "Wyart", "g.wyart@students.ephec.be")
             ->createUser("Lucie", "Hermand", "l.hermand@students.ephec.be")
             ->createUser("Arno", "Godart", "a.godart@students.ephec.be")
             ->createUser("Adrien", "Nini", "a.ninipereira@students.ephec.be")
             ->createUser("Robin", "Gielen", "r.gielen@students.ephec.be")
             ->createUser("Fabian", "Descampe", "f.descampe@students.ephec.be")
             ->createUser("Simon", "Fauconnier", "s.fauconnier@students.ephec.be")
             ->createUser("Sebastien", "Raemdonck", "s.raemdonck@students.ephec.be")
             ->createUser("Thomas", "Feyereisen", "t.feyereisen@students.ephec.be");

        $this->createStudent(0)
             ->createStudent(1)
             ->createStudent(2)
             ->createStudent(3)
             ->createStudent(4);

        $this->createCoach(5)
             ->createCoach(6)
             ->createCoach(7)
             ->createCoach(8)
             ->createCoach(9);

        foreach($this->listCoach as $coach) {

            for($i = 1; $i <= mt_rand(1, 10); $i++) {

                $formation = $this->createFormation($coach);
                
                for($i = 1; $i <= mt_rand(1, 5); $i++) {
                    
                    $formation->addStudent($this->listStudent[(mt_rand(0, count($this->listStudent) - 1))]);
                }
                $manager->persist($formation);
                
                for($i = 1; $i <= mt_rand(1, 50); $i++) {
        
                    $exercice = $this->createExercice($formation);
                    $manager->persist($exercice);
                }

                for($i = 1; $i <= mt_rand(1, 20); $i++) {
        
                    $comment = $this->createComment($formation);
                    $manager->persist($comment);
                }
            }
        }


        $this->persist($this->listUser, $manager);
        $this->persist($this->listStudent, $manager);
        $this->persist($this->listCoach, $manager);

        $manager->flush();
    }

    private function persist($list, $manager) {

        foreach($list as $obj) {

            $manager->persist($obj);
        }
    }

    private function createUser($name, $lastName, $email) {

        $user = new User();
        $hash = $this->encoder->encodePassword($user, 'password');
        $user->setName($name)
             ->setLastName($lastName)
             ->setEmail($email)
             ->setHash($hash);

        $this->listUser[] = $user;
        return $this;
    }

    private function createStudent($id) {

        $student = new Student();
        $student->setUser($this->listUser[$id]);

        $this->listStudent[] = $student;
        return $this;
    }

    private function createCoach($id) {

        $coach = new Coach();
        $coach->setUser($this->listUser[$id]);

        $this->listCoach[] = $coach;
        return $this;
    }

    private function createFormation($coach) {

        $formation = new Formation();
        $titre = $this->faker->sentence();
        $introduction = join(", ", $this->faker->paragraphs(3));

        $formation-> setTitre($titre)
                  -> setIntroduction($introduction)
                  -> setImage("https://placehold.it/1300x500")
                  ->setCoach($coach);

        $this->listFormation[] = $formation;

        return $formation;

    }

    private function createExercice($formation) {

        $exercice = new Exercice();
        $title = $this->faker->sentence();
        $content = join(", ", $this->faker->paragraphs(3));

        $exercice->setTitle($title)
                  ->setContent($content)
                  ->setFormation($formation);

        $this->listExercice[] = $exercice;

        return $exercice;

    }

    private function createComment($formation) {

        $comment = new Comment();
        $note = mt_rand(0, 10);
        $content = join(", ", $this->faker->paragraphs(3));

        $comment->setNote($note)
                ->setContent($content)
                ->setWriter($this->listStudent[mt_rand(0, count($this->listStudent) - 1)])
                ->setFormation($formation);

        return $comment;
    }
}
