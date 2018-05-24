<?php

namespace Tests\Feature;

use App\Category;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_delete_a_category()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create(['user_id' => $user->id]);

        Passport::actingAs($user);

        $this->assertEquals(1, Category::all()->count());

        $this->json('DELETE', '/api/categories/' . $category->id)
            ->assertStatus(204);

        $this->assertEquals(0, Category::all()->count());
    }
}
