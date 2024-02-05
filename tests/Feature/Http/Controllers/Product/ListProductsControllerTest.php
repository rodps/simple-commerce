<?php

namespace Tests\Feature\Http\Controllers\Product;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_return_10_products(): void
    {
        // Arrange
        $user = User::factory()->create();
        $this->seed(ProductSeeder::class);

        // Act
        $response = $this->actingAs($user)->getJson('/api/products');

        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJson([
                'current_page' => 1,
                'last_page' => 2
            ]);
    }

    public function test_should_return_5_products(): void
    {
        // Arrange
        $user = User::factory()->create();
        $this->seed(ProductSeeder::class);

        // Act
        $response = $this->actingAs($user)->getJson('/api/products?limit=5');

        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJson([
                'current_page' => 1,
                'last_page' => 4
            ]);
    }

    public function test_should_return_5_products_from_page_2(): void
    {
        // Arrange
        $user = User::factory()->create();
        $this->seed(ProductSeeder::class);

        // Act
        $response = $this->actingAs($user)->getJson('/api/products?limit=5&page=2');

        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonPath('current_page', 2);
    }

    public function test_should_return_401_if_user_not_authorized(): void
    {
        // Act
        $response = $this->getJson('/api/products');

        // Assert
        $response->assertStatus(401);
    }

    public function test_should_return_1_product_by_name(): void
    {
        // Arrange
        $this->seed(ProductSeeder::class);
        $user = User::factory()->create();
        $product = Product::factory()->for($user)->create();

        // Act
        $response = $this->actingAs($user)->getJson("/api/products?name={$product->name}");

        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', $product->name);
    }

    public function should_return_products_by_max_price(): void
    {
        // Arrange
        $user = User::factory()->create();
        Product::factory()->for($user)->create([
            'price' => 100,
            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'image' => fake()->imageUrl()
        ]);
        Product::factory()->for($user)->create([
            'price' => 200,
            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'image' => fake()->imageUrl()
        ]);
        Product::factory()->for($user)->create([
            'price' => 300,
            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'image' => fake()->imageUrl()
        ]);

        // Act
        $response = $this->actingAs($user)->getJson('/api/products?max_price=200');

        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function should_return_products_by_min_price(): void
    {
        // Arrange
        $user = User::factory()->create();
        Product::factory()->for($user)->create([
            'price' => 100,
            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'image' => fake()->imageUrl()
        ]);
        Product::factory()->for($user)->create([
            'price' => 200,
            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'image' => fake()->imageUrl()
        ]);
        Product::factory()->for($user)->create([
            'price' => 300,
            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'image' => fake()->imageUrl()
        ]);

        // Act
        $response = $this->actingAs($user)->getJson('/api/products?min_price=250');

        // Assert
        $response
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }
}
