<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * POST /api/users
     */
    public function test_the_user_is_created_successfully(): void
    {
        // Arrange
        $data = [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password(),
        ];

        // Act
        $response = $this->post('/api/users', $data);

        // Assert
        $response
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
            ])
            ->assertJson([
                'name' => $data['name'],
                'email' => $data['email'],
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
        $this->assertDatabaseCount('users', 1);
        $this->assertTrue(Hash::check($data['password'], User::first()->password));
    }

    public function test_the_user_is_not_created_with_invalid_data()
    {
        $this->post('/api/users', [])
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name',
                    'email',
                    'password',
                ]
            ]);

        $this->assertDatabaseCount('users', 0);
    }

    public function test_the_user_is_not_created_with_an_existing_email()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->post('/api/users', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => fake()->password(),
        ]);

        // Assert
        $response
            ->assertJsonStructure([
                'message'
            ])
            ->assertStatus(409);

        $this->assertDatabaseCount('users', 1);
    }
}
