<?php

namespace Tests\Feature;

use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_add_a_new_category()
    {
        $user = factory(User::class)->create();
        $name = 'Category Name';

        Passport::actingAs($user);

        $this->json('POST', '/api/categories', [
            'name' => $name,
        ])
            ->assertStatus(200)
            ->assertJson(['name' => $name]);
    }

    /** @test */
    public function user_cannot_add_a_new_category_without_a_name()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $this->withExceptionHandling()
            ->json('POST', '/api/categories', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }
}
