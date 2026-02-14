<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\CurrencyHelper;

class CurrencyHelperTest extends TestCase
{
    /**
     * Test basic formatting of integers.
     */
    public function test_formats_integer_correctly()
    {
        $this->assertEquals('Rp 10.000', CurrencyHelper::formatRupiah(10000));
        $this->assertEquals('Rp 1.000.000', CurrencyHelper::formatRupiah(1000000));
        $this->assertEquals('Rp 0', CurrencyHelper::formatRupiah(0));
    }

    /**
     * Test formatting of float numbers.
     * Decimals should be rounded/truncated as per standard rupiah display (usually 0 decimals).
     */
    public function test_formats_float_correctly()
    {
        $this->assertEquals('Rp 10.500', CurrencyHelper::formatRupiah(10500.00));
        // number_format rounds half up by default or just formats. 
        // 10500.5 -> 10,501 if decimals=0? Let's check behavior.
        // number_format(10500.5, 0) -> 10,501.
        $this->assertEquals('Rp 10.501', CurrencyHelper::formatRupiah(10500.50));
    }

    /**
     * Test handling of string inputs that are numeric.
     */
    public function test_formats_numeric_string_correctly()
    {
        $this->assertEquals('Rp 50.000', CurrencyHelper::formatRupiah('50000'));
    }

    /**
     * Test handling of non-numeric inputs.
     */
    public function test_handles_invalid_input()
    {
        $this->assertEquals('Rp 0', CurrencyHelper::formatRupiah(null));
        $this->assertEquals('Rp 0', CurrencyHelper::formatRupiah('abc'));
    }
}
