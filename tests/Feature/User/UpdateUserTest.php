<?php

namespace Tests\Feature;

use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_info_can_be_updated()
    {
        $user = factory(User::class)->create();

        $data = [
            'name' => 'John Doe',
            'email' => 'foo@bar.com',
            'password' => 'secret',
        ];

        Passport::actingAs($user);

        $this->json('PATCH', '/api/users/' . $user->id, $data)
            ->assertStatus(200);

        $user = $user->fresh();
        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
    }

    /** @test */
    public function user_info_cannot_be_updated_by_unauthenticated_user()
    {
        $user = factory(User::class)->create();

        $this->withExceptionHandling()->json('PATCH', '/api/users/' . $user->id, [
            'name' => 'John Doe',
            'email' => 'foo@bar.com',
            'password' => 'secret',
        ])
            ->assertStatus(401);
    }

    /** @test */
    public function user_info_cannot_be_updated_by_different_user()
    {
        $user = factory(User::class)->create();
        $differentUser = factory(User::class)->create();

        Passport::actingAs($differentUser);

        $this->withExceptionHandling()->json('PATCH', '/api/users/' . $user->id, [
            'name' => 'John Doe',
            'email' => 'foo@bar.com',
            'password' => 'secret',
        ])
            ->assertStatus(403);
    }

    /** @test */
    public function name_field_is_required_when_updating_user()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $this->withExceptionHandling()->json('PATCH', '/api/users/' . $user->id, [
            'password' => 'secret',
            'email' => 'foo@bar.com',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function password_field_is_not_required_when_updating_user()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $this->json('PATCH', '/api/users/' . $user->id, [
            'name' => 'John',
            'email' => 'foo@bar.com',
        ])
            ->assertStatus(200);
    }

    /** @test */
    public function email_field_is_required_when_updating_user()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $this->withExceptionHandling()->json('PATCH', '/api/users/' . $user->id, [
            'name' => 'John',
            'password' => 'secret',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }
}
