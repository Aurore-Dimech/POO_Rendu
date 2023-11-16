<?php

abstract class Utils { //permet de générer des nombres aléatoires présents entre le minimum et le maximum déclarés
    static public function generateRandomNumber($min, $max) { //la fonction est mise en statique afin de pouvoir être appelée en-dehors de la classe sans devoir reprendre la classe d'abord
        return rand($min, $max);
    }
}

?>