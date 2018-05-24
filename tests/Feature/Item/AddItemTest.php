<?php

namespace Tests\Feature\Item;

use App\Category;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_add_a_new_item()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create(['user_id' => $user->id]);

        $name = 'Item name';
        $description = 'Item description';

        Passport::actingAs($user);

        $this->json('POST', '/api/categories/' . $category->id . '/items', [
            'name' => $name,
            'description' => $description,
        ])
            ->assertStatus(200)
            ->assertJson([
                'name' => $name,
                'description' => $description,
            ]);
    }

    /** @test */
    public function user_cannot_add_a_new_item_without_a_name_or_description()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create(['user_id' => $user->id]);

        Passport::actingAs($user);

        $this->withExceptionHandling()
            ->json('POST', '/api/categories/' . $category->id . '/items')
            ->assertStatus(422)
            ->assertJsonValidationErrors('name', 'description');
    }
}
