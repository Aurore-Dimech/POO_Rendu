<?php
require('variables.php');

abstract class Character { //cela permet de créer une classe qui définit les propriétés partagées par tous les personnages du jeu, c'est à dire, dans le cas présent, tous les personnages appartenant aux classes filles "Hero" et "Enemy". Elle est mise en abstract car elle définit une méthode, mais que les arguments sont donnés par les enfants.
    protected $name ; //en protected pour les protéger ; ils ne sont pas modifiés au cours de la partie, donc il n'y a pas besoin de faire de setter
    protected $nbMarbles ;

    protected function __construct($name, $nbMarbles){ //permet d'initialiser les valeurs correspondant au nom et au nombre de billes ; le protected permet de garder ces infos privées, tout en restant accessibles aux classes filles (ce qu'on veut puisqu'on va les rappeler dans les classes filles)
        $this->name = $name;
        $this->nbMarbles = $nbMarbles;
    }

    final public function getName() { //le final permet d'éviter que la fonction de la classe mère soit surchargée par celles des classes filles, et permet ainsi de les protéger. Le getter permet d'appeler en dehors de la classe la variable qu'il reprend (ici $name) tout en la gardant protégée
        return $this->name;
    }

    final public function getNbMarbles() {
        return $this->nbMarbles ;
    }

}

class Hero extends Character { //le extend permet de définir cette classe comme étant une classe fille de celle Character
    private $loss;
    private $gain;
    private $warScream;

    public function __construct($name, $nbMarbles, $loss, $gain, $war_scream) { 
        parent::__construct($name, $nbMarbles); //permet de reprendre des éléments définis dans la classe mère
        $this->loss = $loss;
        $this->gain = $gain;
        $this->war_scream = $war_scream;
    }

    public function getLoss() { 
        return $this->loss;
    }

    public function getGain() { 
        return $this->gain;
    }

    public function getWarScream() { 
        return $this->warScream;
    }

    public function setNbMarbles($nbMarbles) { //un setter est utilisé ici puisque cette valeur doit pouvoir être modifiée au cours de la partie.
        return $this->nbMarbles = $nbMarbles;
    }
}

class Enemy extends Character {
    private $age;

    public function __construct($name, $nbMarbles, $age) {
        parent::__construct($name, $nbMarbles);
        $this->age = $age;
    }

    public function getAge() {
        return $this->age;
    }
}

$heroArray = [ //dans ce tableau, je définis tous les héros potentiels ainsi que leurs caractéristiques. Ils sont définis à partir du constructeur établi dans la classe Hero, et les paramètres définis correspondent ainsi à l'ordre défini dans celui-ci (dans le cas présent : nom, nombre de bille, perte supplémentaire en cas d'échec, gain supplémentaire en cas de victoire, cri de guerre).
    new Hero('Seong Gi-hun', 15, 2, 1, 'bouh'),
    new Hero('Kang Sae-byeok', 25, 1, 2, 'bouuh'),
    new Hero('Cho Sang-woo', 35, 0, 3, 'bouuuh')
];

?>