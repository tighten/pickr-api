<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registering_a_new_user()
    {
        $data = [
            'name' => 'John Doe',
            'password' => 'secret',
            'email' => 'foo@bar.com',
        ];

        $this->json('POST', '/api/users', $data)
            ->assertStatus(200)
            ->assertJson([
                'name' => $data['name'],
                'email' => $data['email']
            ])
            ->assertJsonMissing(['password']);
    }

    /** @test */
    public function name_field_is_required_when_registering_user()
    {
        $this->withExceptionHandling()->json('POST', '/api/users', [
            'password' => 'secret',
            'email' => 'foo@bar.com',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function password_field_is_required_when_registering_user()
    {
        $this->withExceptionHandling()->json('POST', '/api/users', [
            'name' => 'John',
            'email' => 'foo@bar.com',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('password');
    }

    /** @test */
    public function email_field_is_required_when_registering_user()
    {
        $this->withExceptionHandling()->json('POST', '/api/users', [
            'name' => 'John',
            'password' => 'secret',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    /** @test */
    public function email_cannot_be_duplicate()
    {
        $email = 'foo@bar.com';
        factory(User::class)->create(['email' => $email]);

        $this->withExceptionHandling()->json('POST', '/api/users', [
            'name' => 'John',
            'email' => $email,
            'password' => 'secret',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }
}
