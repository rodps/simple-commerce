<?php

namespace Tests\Feature\Http\Controllers\Admin\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowProductControllerTest extends TestCase
{

    use RefreshDatabase;

    public function test_should_return_ok(): void
    {
        // Arrange
        $user = User::factory()->admin()->create();
        $product = Product::factory()->for($user)->create();

        // Act
        $response = $this->actingAs($user)->getJson("/api/admin/products/{$product->id}");

        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'name', 'description', 'price', 'image', 'created_at', 'updated_at'])
            ->assertJson($product->toArray());
    }

    public function test_should_return_404_if_product_not_found(): void
    {
        // Arrange
        $user = User::factory()->admin()->create();

        // Act
        $response = $this->actingAs($user)->getJson('/api/admin/products/1');

        // Assert
        $response->assertStatus(404);
    }

    public function test_should_return_401_if_user_is_not_authenticated(): void
    {
        // Act
        $response = $this->getJson("/api/admin/products/1");

        // Assert
        $response->assertStatus(401);
    }
}
