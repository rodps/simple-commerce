<?php

namespace Tests\Feature\Http\Controllers\Admin\Product;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_product_is_created_successfully()
    {
        // Arrange
        $user = User::factory()->admin()->create();

        $data = [
            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'price' => fake()->randomNumber(),
            'image' => fake()->imageUrl()
        ];

        // Act
        $response = $this->actingAs($user)->postJson('/api/admin/products',  $data);

        // Assert
        $response
            ->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'description', 'price', 'image', 'created_at', 'updated_at'])
            ->assertJson($data);

        $this->assertDatabaseHas('products', array_merge($data, ['user_id' => $user->id]));
        $this->assertDatabaseCount('products', 1);
    }
}
