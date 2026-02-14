<?php

namespace Tests\Feature;

use App\Models\PriceList;
use App\Models\Pegawai;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PriceListTest extends TestCase
{
    use DatabaseTransactions;

    private function createPegawai()
    {
        return Pegawai::create([
            'nama_pegawai' => 'Test User',
            'username' => 'testuser' . uniqid(),
            'password' => Hash::make('password'),
            'jabatan' => 'Staff',
            'status' => 'AKTIF',
        ]);
    }

    public function test_price_list_screen_can_be_rendered()
    {
        $user = $this->createPegawai();

        $response = $this->actingAs($user)->get('/price-list');

        $response->assertStatus(200);
    }

    public function test_create_price_list_item()
    {
        $user = $this->createPegawai();

        $response = $this->actingAs($user)->post('/price-list', [
            'nama_item' => 'Test Item',
            'harga' => 100000,
            'kode_item' => 'ITMTEST',
            'form_a' => true,
        ]);

        $response->assertRedirect('/price-list');
        $this->assertDatabaseHas('price_list', [
            'nama_item' => 'Test Item',
            'harga' => 100000,
            'kode_item' => 'ITMTEST',
            'form_a' => 1,
        ]);
    }

    public function test_search_functionality()
    {
        $user = $this->createPegawai();
        PriceList::create(['nama_item' => 'Apple', 'harga' => 1000, 'kode_item' => 'A001']);
        PriceList::create(['nama_item' => 'Banana', 'harga' => 2000, 'kode_item' => 'B001']);

        $response = $this->actingAs($user)->get('/price-list?search=Apple');

        $response->assertSee('Apple');
        $response->assertDontSee('Banana');
    }

    public function test_filter_functionality()
    {
        $user = $this->createPegawai();
        PriceList::create(['nama_item' => 'Active Item', 'harga' => 1000, 'is_active' => true]);
        PriceList::create(['nama_item' => 'Inactive Item', 'harga' => 2000, 'is_active' => false]);

        $response = $this->actingAs($user)->get('/price-list?status=1');

        $response->assertSee('Active Item');
        $response->assertDontSee('Inactive Item');
    }

    public function test_category_filter_functionality()
    {
        $user = $this->createPegawai();
        PriceList::create(['nama_item' => 'Form A Item', 'harga' => 1000, 'form_a' => true]);
        PriceList::create(['nama_item' => 'Form B Item', 'harga' => 2000, 'form_b' => true]);

        $response = $this->actingAs($user)->get('/price-list?category=form_a');

        $response->assertSee('Form A Item');
        $response->assertDontSee('Form B Item');
    }
}
