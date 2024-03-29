<?php

namespace Tests\Feature\Http\Controllers\Admin\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_update_product_with_success(): void
    {
        // Arrange
        $user = User::factory()->admin()->create();
        $product = Product::factory()->for($user)->create();

        $data = $product->toArray();
        $data['name'] = 'new name';

        // Act
        $response = $this->actingAs($user)->putJson("/api/admin/products/{$product->id}", $data);

        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'name', 'description', 'price', 'image', 'created_at', 'updated_at'])
            ->assertJson($data);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $data['image'],
            'user_id' => $user->id
        ]);
        $this->assertDatabaseCount('products', 1);
    }

    public function test_should_return_404_if_product_not_found(): void
    {
        // Arrange
        $user = User::factory()->admin()->create();

        $data = [
            'name' => 'new name',
            'description' => 'new description',
            'price' => 100,
            'image' => 'new image'
        ];

        // Act
        $response = $this->actingAs($user)->putJson('/api/admin/products/1', $data);

        // Assert
        $response->assertStatus(404);
    }

    public function test_should_return_403_if_user_not_authorized(): void
    {
        // Arrange
        $user = User::factory()->admin()->create();
        $product = Product::factory()->for($user)->create();

        $notAuthorizedUser = User::factory()->create();

        $data = [
            'name' => 'new name',
            'description' => 'new description',
            'price' => 100,
            'image' => 'new image'
        ];

        // Act
        $response = $this->actingAs($notAuthorizedUser)->putJson("/api/admin/products/{$product->id}", $data);

        // Assert
        $response->assertStatus(403);
    }
}
