<?php

namespace Tests\Feature;

use App\Category;
use App\Item;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_get_their_categories_and_items()
    {
        $user = factory(User::class)->create();

        factory(Item::class, 2)->create([
            'category_id' => function () use ($user) {
                return factory (Category::class)->create(['user_id' => $user->id])->id;
            }
        ]);

        $categories = Category::all();
        $this->assertEquals(2, $categories->count());
        $this->assertEquals(1, $categories->first()->items->count());

        Passport::actingAs($user);

        $this->json('GET', '/api/categories')
            ->assertStatus(200)
            ->assertJson($categories->toArray());
    }
}
