<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Autenticamos un usuario por defecto para todas las peticiones Feature de este controlador
        Sanctum::actingAs(User::factory()->create());
    }

    public function test_index()
    {
        Product::factory()->count(5)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
    }

   public function test_create_new_product()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $category = Category::factory()->create();

        $data = [
            'name'        => 'New Product',
            'description' => 'Product description detail',
            'price'       => 15000, 
            'category_id' => $category->id,
        ];

        $response = $this->postJson('/api/products', $data);

        $response->assertStatus(201)
                 ->assertHeader('content-type', 'application/json');

        $this->assertDatabaseHas('products', [
            'name'  => 'New Product',
            'price' => 15000
        ]);
    }

    public function test_update_product()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $product = Product::factory()->create();

        $data = [
            'name'        => 'Update Product',
            'price'       => 22500, 
            'category_id' => $product->category_id,
        ];

        $response = $this->putJson("/api/products/{$product->id}", $data);

        $response->assertSuccessful();
        
        $this->assertDatabaseHas('products', [
            'id'   => $product->id,
            'name' => 'Update Product',
            'price'=> 22500
        ]);
    }

    public function test_show_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertSuccessful();
    }

    public function test_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertSuccessful();
        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }
}