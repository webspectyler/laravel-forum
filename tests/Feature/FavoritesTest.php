<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $reply = create('App\Reply');
        $response = $this->post('/replies/'.$reply->id.'/favorite', [
        ]);

        $this->assertCount(1, $reply->favorites);
    }
}
