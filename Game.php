<?php
require_once('Character.php');
require_once('variables.php');

class Game{
    private $hero ;
    private $enemies ;
    private $difficulty ;
    private $randomEnemy;

    public function __construct(){
        $this->hero = $this->selectedHero();
        $this->enemies = $this->generateEnemies();
        $this->difficulty = $this->getDifficulty();
        echo "La partie sera jouée en " . $this->difficulty . ".<br>";
        echo "Le héros sélectionné est " . $this->hero->getName() . ". Il commence la partie avec " . $this->hero->getNbMarbles() . " billes.<br>";

        while (count($this->enemies) > 0 && $this->hero->getNbMarbles() > 0) {
            $this->randomEnemy = Utils::generateRandomNumber(0, count($this->enemies)-1);
            echo $this->hero->getName() . " affronte " . $this->enemies[$this->randomEnemy]->getName() . ", agé de " . $this->enemies[$this->randomEnemy]->getAge() . " ans. <br>";
            $this->round();
            array_splice($this->enemies, $this->randomEnemy, 1);
        };

        if (count($this->enemies) == 0 && $this->hero->getNbMarbles() > 0){
            echo $this->hero->getName() . " est le grand gagant et remporte 45,6 milliards de Won sud-coréen !";
        }
    }

    private function getDifficulty(){
        $difficulty = Utils::generateRandomNumber(1,3);
        
        if ($difficulty == 1) {
            while (count($this->enemies) > 5) {
                array_splice($this->enemies, Utils::generateRandomNumber(0,count($this->enemies)-1), 1);
            }
            return 'facile';

        } else if ($difficulty == 2) {
            while (count($this->enemies) > 10) {
                array_splice($this->enemies, Utils::generateRandomNumber(0,count($this->enemies)-1), 1);
            }
            return 'difficile';

        } else {
            return 'impossible';
        }
    }
    
    private function generateEnemies(){
        $enemyArray = [];
        $names = ['Ahsoka', 'Anakin', 'Padmé', 'Qui-Gon', 'Luke', 'Leila', 'Dooku', 'Yoda', 'Obi-Wan', 'Han Solo', 'Chewbacca', 'Rex', 'Grevious', 'Maul', 'Palpatine', 'Jar-Jar', 'C3P0', 'Boba', 'Grogu', 'Jabba'];
        foreach ($names as $name) {
            $enemyArray[] = new Enemy($name, Utils::generateRandomNumber(1,20), Utils::generateRandomNumber(20,80));
        }
        return $enemyArray;
    }

    private function selectedHero() {
        global $heroArray;
        return $heroArray[Utils::generateRandomNumber(0, count($heroArray)-1)];
    }

    private function round(){
        $herosGuess = Utils::generateRandomNumber(0,1);
        $cheat = Utils::generateRandomNumber(0,1);

        if ($this->enemies[$this->randomEnemy]->getAge() >= 70 && $cheat == 1){
            echo $this->hero->getName() . " triche discrètement et donc gagne ainsi la manche. Il remporte les " . $this->enemies[$this->randomEnemy]->getNbMarbles() . " billes de " . $this->enemies[$this->randomEnemy]->getName() . " et en a donc au total " . $this->hero->getNbMarbles() . ".<br>";
        } else if ($herosGuess == $this->enemies[$this->randomEnemy]->getNbMarbles() % 2) {
            echo $this->hero->getName() . " devine correctement et donc gagne la manche. Il remporte " . ($this->enemies[$this->randomEnemy]->getNbMarbles() + $this->hero->getGain()) . " billes. ";
            $this->hero->setNbMarbles($this->hero->getNbMarbles() + $this->hero->getGain() + $this->enemies[$this->randomEnemy]->getNbMarbles());
            echo "Il en a maintenant " . $this->hero->getNbMarbles() . ".<br>";        
        } else {
            $this->hero->setNbMarbles($this->hero->getNbMarbles()-($this->enemies[$this->randomEnemy]->getNbMarbles() + $this->hero->getLoss()));
            echo $this->hero->getName() . " se trompe et donc perd la manche. " . $this->enemies[$this->randomEnemy]->getName() . " avait " . $this->enemies[$this->randomEnemy]->getNbMarbles() . " billes. Il perd au total " . ($this->enemies[$this->randomEnemy]->getNbMarbles() + $this->hero->getLoss()) . " billes.";
            if ($this->hero->getNbMarbles() > 0){
                echo " Il lui reste maintenant " . $this->hero->getNbMarbles() . " billes.<br>";
            } else {
                echo "<br> Il ne lui reste plus de billes ! Il est de ce fait éliminé de la partie. Dommage !";
            }
        }
    }
}
?>