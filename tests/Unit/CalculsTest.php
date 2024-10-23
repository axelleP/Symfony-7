<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Trait\CalculsTrait;

class CalculsTest extends TestCase
{
    use CalculsTrait;

    /**
     * @dataProvider providerCalculateTTC
     */
    public function test_calculateTTC(float $priceHT, float $rateTVA, float $expectedResult): void
    {
        $amountTTC = $this->calculateTTC($priceHT, $rateTVA);
        $this->assertEquals($expectedResult, $amountTTC, 'Calcul montant TTC incorrect.');
    }

    public static function providerCalculateTTC()
    {
        return [
            [99.99, 20, 119.99],
            [8, 20, 9.6],
        ];
    }
}