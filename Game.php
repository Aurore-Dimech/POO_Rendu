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
        echo "La partie sera jouée en " . $this->difficulty . ".<br>"; // les . permettent de pouvoir liés plusieurs éléments ayant des types différents dans un même echo
        echo "Le héros sélectionné est " . $this->hero->getName() . ". Il commence la partie avec " . $this->hero->getNbMarbles() . " billes.<br><br>";

        while (count($this->enemies) > 0 && $this->hero->getNbMarbles() > 0) { //lance une boucle qui ne se finie que lorsque le nombre d'éléments présents dans le tableau "enemies" est inférieur à 1, ou lorsque le nombre de billes possédées par le héros est inférieur à 1
            $this->randomEnemy = Utils::generateRandomNumber(0, count($this->enemies)-1); //permet de choisir un objet au hasard entre tous ceux présents dans le tableau "enemies". Puisque le premier ennemie correspond au nombre 0 mais que le compte débute à 1, il faut enlever un élément au nombre total d'éléments présents dans le tableau pour pouvoir sélectionner au hasard un élément présent dans le tableau, et non en-dehors de celui-ci.
            echo $this->hero->getName() . " affronte " . $this->enemies[$this->randomEnemy]->getName() . ", agé de " . $this->enemies[$this->randomEnemy]->getAge() . " ans. <br>";
            $this->round(); //lance la fonction round. Du fait de la boucle while, elle se joue à répétition jusque la fin de la partie
            array_splice($this->enemies, $this->randomEnemy, 1); //à chaque boucle, on retire grâce à cette ligne l'ennemie que le héro a affronté durant ce round. Cela permet déjà d'avoir un décompte du nombre d'ennemies qu'il reste à affronter, pouvoir arrêter la partie lorsque le nombre de round définie par la difficulté est dépassé, ainsi que d'éviter d'affronter plusieurs fois le même ennemie.
        };

        if (count($this->enemies) == 0 && $this->hero->getNbMarbles() > 0){ //si la partie est finie, et que le héros possède dans sa main plus de une bille, cela signifie que la partie s'est arrêtée car tous le nombre de round défini par la difficulté a été passé. Donc, il ne s'agit que du scénario dans lequel le héros gagne la partie entière, d'où le prix de 45,6 milliards de Won sud-coréens gagné
            echo "<br>" . $this->hero->getName() . " est le grand gagant et remporte 45,6 milliards de Won sud-coréen !";
        }
    }

    private function getDifficulty(){ //permet de choisir aléatoirement le niveau de difficulté
        $difficulty = Utils::generateRandomNumber(1,3); //Puisqu'il y a 3 niveaux de difficulté, je lui demande de choisir aléatoirement un entier entre 1, 2 ou 3
        
        if ($difficulty == 1) { //selon le nombre généré, un code différent se joue, et permet de garder dans le tableau "ennemies" que le nombre d'objet correspondant au niveau de difficulté tel que défini dans les consignes
            while (count($this->enemies) > 5) {
                array_splice($this->enemies, Utils::generateRandomNumber(0,count($this->enemies)-1), 1); //ici, on coupe aléatoirement un élément afin que chaque partie permette d'affronter une suite d'ennemies différente, plutôt que toujours la même pour un même niveau de difficulté
            }
            return 'facile';

        } else if ($difficulty == 2) {
            while (count($this->enemies) > 10) {
                array_splice($this->enemies, Utils::generateRandomNumber(0,count($this->enemies)-1), 1);
            }
            return 'difficile';

        } else {
            return 'impossible'; //Puisque le tableau contient de base 20 éléments, il n'y a pas besoin d'en couper dans le mode impossible
        }
    }
    
    private function generateEnemies(){
        $enemyArray = [];
        $names = ['Ahsoka', 'Anakin', 'Padmé', 'Qui-Gon', 'Luke', 'Leila', 'Dooku', 'Yoda', 'Obi-Wan', 'Han Solo', 'Chewbacca', 'Rex', 'Grevious', 'Maul', 'Palpatine', 'Jar-Jar', 'C3P0', 'Boba', 'Grogu', 'Jabba']; //je définis ici les noms des différents ennemis que le héros va potentiellement affronter
        foreach ($names as $name) { //pour chaque nom, on instance un nouvel ennemi avec un nombre de billes et un âge aléatoire
            $enemyArray[] = new Enemy($name, Utils::generateRandomNumber(1,40), Utils::generateRandomNumber(20,80));
        }
        return $enemyArray;
    }

    private function selectedHero() {
        global $heroArray; //permet de faire appel au tableau contenant tous les personnages
        return $heroArray[Utils::generateRandomNumber(0, count($heroArray)-1)]; //permet de sélectionner aléatoirement un des personnages du tableau
    }

    private function round(){
        $herosGuess = Utils::generateRandomNumber(0,1); //permet de simplifier le fait de deviner pair ou impair. Si le nombre généré est 0, le choix du héro est considéré comme pair ; s'il s'agit de 1, il est alors impair
        $cheat = Utils::generateRandomNumber(0,1); //selon si 1 ou 0 est sélectionné, cela définit le fait de tricher ou pas. 

        if ($this->enemies[$this->randomEnemy]->getAge() >= 70 && $cheat == 1){ //cet endroit permet de jouer le bonus. Si l'ennemi à 70ans ou plus, et la variable cheat est égale à 1, on admet qu'il accepte de tricher ; si la variable cheat est à 0, il s'agit du scénario i=où il décide de ne pas tricher. Si l'ennemi n'a pas 70 ans, alors le héros n'a pas la possibilité de tricher
            echo $this->hero->getName() . " triche discrètement et donc gagne ainsi la manche. Il remporte les " . $this->enemies[$this->randomEnemy]->getNbMarbles() . " billes de " . $this->enemies[$this->randomEnemy]->getName() . " et en a donc au total " . $this->hero->getNbMarbles() . ".<br><br>";
        } else if ($herosGuess == $this->enemies[$this->randomEnemy]->getNbMarbles() % 2) { // %2 renvoie 1 si le nombre de billes de l'ennemi est impair, et 0 si ce nombre est pair. Le résultat obtenu est alors comparé au choix du héro. On a 4 scénarios possibles. Cette boucle gère les deux scénarios suivants : 0 et 0, où le héro devine pair et le nombre de billes de l'ennemi est pair, et  1 et 1, où le héro devine impair et le nombre de billes de l'ennemi est impair
            echo $this->hero->getName() . " devine correctement et donc gagne la manche. " . $this->enemies[$this->randomEnemy]->getName() . " avait " . $this->enemies[$this->randomEnemy]->getNbMarbles() . " billes. ". "Il remporte " . ($this->enemies[$this->randomEnemy]->getNbMarbles() + $this->hero->getGain()) . " billes. ";
            $this->hero->setNbMarbles($this->hero->getNbMarbles() + $this->hero->getGain() + $this->enemies[$this->randomEnemy]->getNbMarbles());
            echo "Il en a maintenant " . $this->hero->getNbMarbles() . ".<br><br>";        
        } else { // gère les 2 autres scénarios restants, c'est à dire : 1 et 0, où le héro dit que le nombre de billes de l'ennemi est impair alors qu'il est pair, et 0 et 1 où le héro dit que le nombre de billes de l'ennemi est pair alors qu'il est impair
            $this->hero->setNbMarbles($this->hero->getNbMarbles()-($this->enemies[$this->randomEnemy]->getNbMarbles() + $this->hero->getLoss()));
            echo $this->hero->getName() . " se trompe et donc perd la manche. " . $this->enemies[$this->randomEnemy]->getName() . " avait " . $this->enemies[$this->randomEnemy]->getNbMarbles() . " billes. Il perd au total " . ($this->enemies[$this->randomEnemy]->getNbMarbles() + $this->hero->getLoss()) . " billes.";
            if ($this->hero->getNbMarbles() > 0){
                echo " Il lui reste maintenant " . $this->hero->getNbMarbles() . " billes.<br><br>";
            } else {
                echo "<br><br> Il ne lui reste plus de billes ! Il est de ce fait éliminé de la partie. Dommage !";
            }
        }
    }
}
?>