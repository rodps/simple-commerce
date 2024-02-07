<?php

namespace Tests\Feature\Http\Controllers\Admin\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_return_204_on_success(): void
    {
        // Arrange
        $user = User::factory()->create();
        $product = Product::factory()->for($user)->create();

        // Act
        $response = $this->actingAs($user)->deleteJson("/api/admin/products/{$product->id}");

        // Assert
        $response->assertNoContent();
    }

    public function test_should_return_404_if_product_does_not_exist(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->deleteJson('/api/admin/products/1');

        // Assert
        $response->assertStatus(404);
    }

    public function test_should_return_401_if_user_is_not_authenticated(): void
    {
        // Arrange
        $user = User::factory()->create();
        $product = Product::factory()->for($user)->create();

        // Act
        $response = $this->deleteJson("/api/admin/products/{$product->id}");

        // Assert
        $response->assertStatus(401);
    }

    public function test_should_delete_product_from_database(): void
    {
        // Arrange
        $user = User::factory()->create();
        $product = Product::factory()->for($user)->create();
        $this->assertDatabaseCount('products', 1);

        // Act
        $this->actingAs($user)->deleteJson("/api/admin/products/{$product->id}");

        // Assert
        $this->assertDatabaseCount('products', 0);
    }

    public function test_should_return_403_if_user_not_authorized(): void
    {
        // Arrange
        $user = User::factory()->create();
        $product = Product::factory()->for($user)->create();

        $notAuthorizedUser = User::factory()->create();

        // Act
        $response = $this->actingAs($notAuthorizedUser)->deleteJson("/api/admin/products/{$product->id}");

        // Assert
        $response->assertStatus(403);
    }
}
