<?php
require('variables.php');

abstract class Character {
    protected $name ; //en protected pour les protéger ; ils ne sont pas modifiés au cours de la partie, donc il n'y a pas besoin de faire de setter
    protected $nbMarbles ;

    protected function __construct($name, $nbMarbles){ //permet d'initialiser les valeurs correspondant au nom et au nombre de billes ; le protected permet de garder ces infos privées, tout en restant accessibles aux classes filles (ce qu'on veut puisqu'on va les rappeler dans les classes filles)
        $this->name = $name;
        $this->nbMarbles = $nbMarbles;
    }

    final public function getName() { 
        return $this->name;
    }

    final public function getNbMarbles() {
        return $this->nbMarbles ;
    }
}

class Hero extends Character {
    private $loss;
    private $gain;
    private $warScream;
    // public $choice;

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

    public function setNbMarbles($nbMarbles) {
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

$heroArray = [
    new Hero('Seong Gi-hun', 15, 2, 1, 'bouh'), //rajouter choice
    new Hero('Kang Sae-byeok', 25, 1, 2, 'bouuh'),
    new Hero('Cho Sang-woo', 35, 0, 3, 'bouuuh')
];

?>