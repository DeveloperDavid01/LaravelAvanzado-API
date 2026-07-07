<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RatingTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_product_belongs_to_many_users()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $user->rate($product, 5);

        $this->assertInstanceOf(User::class, $product->users->first());
    }

    public function test_averageRating()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $product = Product::factory()->create();

        $user->rate($product, 5);
        $user2->rate($product, 3);

        $this->assertEquals(4, $product->averageRating());
    }

    public function test_rating_model()
    {
        
        $user = \App\Models\User::factory()->create();
        $product = \App\Models\Product::factory()->create();

        $user->rate($product, 5);

        $this->assertDatabaseHas('ratings', [
            'qualifier_id'   => $user->id,
            'qualifier_type' => get_class($user),
            'rateable_id'    => $product->id,
            'rateable_type'  => get_class($product),
            'score'          => 5
        ]);
    }
}