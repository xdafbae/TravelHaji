<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Format number to Rupiah currency format.
     * Example: 10000 -> "Rp 10.000"
     *
     * @param float|int $amount
     * @return string
     */
    public static function formatRupiah($amount)
    {
        // Ensure the amount is numeric, default to 0 if null or invalid
        $amount = is_numeric($amount) ? $amount : 0;
        
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
