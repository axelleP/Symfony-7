<?php

namespace App\Trait;

trait CalculsTrait
{
    /**
     * Calcule le montant TTC à partir du montant HT et du taux de TVA.
     *
     * @param float $priceHT Montant hors taxes
     * @param float $rateTVA Taux de TVA en pourcentage
     * @return float Montant toutes taxes comprises
     */
    public function calculateTTC(float $priceHT, float $rateTVA): float
    {
        return round($priceHT * (1 + $rateTVA / 100), 2);
    }
}