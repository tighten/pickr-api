<?php

namespace Tests\Feature;

use App\Category;
use App\Item;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_delete_an_item()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create(['user_id' => $user->id]);
        $item = factory(Item::class)->create(['category_id' => $category->id]);

        Passport::actingAs($user);

        $this->assertEquals(1, Item::all()->count());

        $this->json('DELETE', '/api/categories/' . $category->id . '/items/' . $item->id)
            ->assertStatus(200);

        $this->assertEquals(0, Item::all()->count());
    }
}
