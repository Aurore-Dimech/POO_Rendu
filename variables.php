<?php

class Utils { //permet de générer des nombres aléatoires présents entre le minimum et le maximum déclarés
    static public function generateRandomNumber($min, $max) {
        return rand($min, $max);
    }
}

?>