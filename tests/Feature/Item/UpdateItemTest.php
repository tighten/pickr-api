<?php

namespace Tests\Feature;

use App\Category;
use App\Item;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_update_an_item()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create(['user_id' => $user->id]);
        $item = factory(Item::class)->create(['category_id' => $category->id]);
        $name = 'Item name';
        $description = 'Item description';

        Passport::actingAs($user);

        $this->json('PUT', '/api/categories/' . $category->id . '/items/' . $item->id, [
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
    public function user_cannot_update_an_item_without_a_name_and_description()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create(['user_id' => $user->id]);
        $item = factory(Item::class)->create(['category_id' => $category->id]);

        Passport::actingAs($user);

        $this->withExceptionHandling()
            ->json('PUT', '/api/categories/' . $category->id . '/items/' . $item->id, [])
            ->assertStatus(422)
            ->assertJsonValidationErrors('name', 'description');
    }
}
