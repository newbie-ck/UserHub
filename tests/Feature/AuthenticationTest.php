<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase; // Reset the database after each test
    use WithFaker; // Provides Faker methods for generating fake data

    public function test_user_registration()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'username' => $this->faker->unique()->userName,
            'password' => 'Password@123', // Adjust password as per your validation rules
            'phone_number' => '60123456789', // Adjust phone number as per your validation rules
        ];

        $response = $this->postJson('/register', $userData);

        $response->assertStatus(201)
                 ->assertJsonStructure(['token']);
    }

    public function test_user_login()
    {
        $user = User::factory()->create([
            'username' => 'username123', // Provide a value for the username field
            'password' => bcrypt('Password@123'), // Adjust password as per your validation rules
            'phone_number' => '60123456789',
        ]);

        $credentials = [
            'username' => $user->username,
            'password' => 'Password@123', // Adjust password as per your validation rules
        ];

        $response = $this->postJson('/login', $credentials);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);
    }
}
