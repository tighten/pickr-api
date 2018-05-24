<?php

namespace Tests\Feature;

use App\Category;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_update_a_category()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create(['user_id' => $user->id]);
        $name = 'Category Name';

        Passport::actingAs($user);

        $this->json('PUT', '/api/categories/' . $category->id, [
            'name' => $name,
        ])
            ->assertStatus(200)
            ->assertJson(['name' => $name]);
    }

    /** @test */
    public function user_cannot_update_a_category_without_a_name()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create(['user_id' => $user->id]);

        Passport::actingAs($user);

        $this->withExceptionHandling()
            ->json('PUT', '/api/categories/' . $category->id, [])
            ->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }
}
