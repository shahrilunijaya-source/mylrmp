<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PublicSearchTest extends TestCase
{
    use DatabaseTransactions;

    public function test_home_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('myLRMP');
    }

    public function test_product_search_loads(): void
    {
        $response = $this->get('/produk');
        $response->assertStatus(200);
    }

    public function test_calculator_loads(): void
    {
        $response = $this->get('/kalkulator');
        $response->assertStatus(200);
    }

    public function test_active_product_is_searchable(): void
    {
        $product = Product::where('status', 'active')->first();
        if ($product) {
            $response = $this->get('/produk?q=' . urlencode($product->name));
            $response->assertStatus(200);
        } else {
            $this->markTestSkipped('No active products seeded');
        }
    }

    public function test_inactive_product_detail_returns_404(): void
    {
        $pending = Product::where('status', 'pending')->first();
        if ($pending) {
            $response = $this->get('/produk/' . $pending->id);
            $response->assertStatus(404);
        } else {
            $this->markTestSkipped('No pending products');
        }
    }

    public function test_lang_switch_to_english(): void
    {
        $response = $this->get('/lang/en');
        $response->assertRedirect();
        // follow redirect
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
