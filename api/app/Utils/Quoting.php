<?php

namespace App\Utils;

class Quoting
{
    /**
     * Renvoie la valeur de mise sur le marché de la crypto monnaie
     * @param $cryptoname {string} Le nom de la crypto monnaie
     */
    public static function getFirstCotation($cryptoname)
    {
        // Générez un nombre aléatoire entre 1 et 60,000
        $cotation = ord(substr($cryptoname, 0, 1)) + rand(1, 60000);

        return $cotation;
    }



    /**
     * Renvoie la variation de cotation de la crypto monnaie sur un jour
     * @param $cryptoname {string} Le nom de la crypto monnaie
     */
        public static function getCotationFor($cryptoname)
    {
        // Générez un nombre aléatoire entre 1 et 60,000
        $cotation = rand(1, 60000);

        // Pas besoin de vérifier si la cotation est positive ou négative, elle sera toujours positive
        return $cotation;
    }



}
