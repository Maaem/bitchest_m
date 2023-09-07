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
        return abs(ord(substr($cryptoname, 0, 1)) + rand(0, 10));
    }

    /**
     * Renvoie la variation de cotation de la crypto monnaie sur un jour
     * @param $cryptoname {string} Le nom de la crypto monnaie
     */
    public static function getCotationFor($cryptoname)
    {
        return abs(rand(0, 99) > 40 ? 1 : -1) *
            abs(
                rand(0, 99) > 49
                    ? ord(substr($cryptoname, 0, 1))
                    : abs(ord(substr($cryptoname, -1))) * (rand(1, 10) * 0.01),
            );
    }
}
