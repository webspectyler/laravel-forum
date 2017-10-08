<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_cannot_favorite_anything(){
        $this->withExceptionHandling();
        $response = $this->post('/replies/1/favorites');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $response = $this->post('/replies/'.$reply->id.'/favorites', [
        ]);

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_only_favorite_a_replay_once(){
        $this->signIn();
        $reply = create('App\Reply');

        try{
        $response = $this->post('/replies/'.$reply->id.'/favorites', [
        ]);
        $response = $this->post('/replies/'.$reply->id.'/favorites', [
        ]);
    }catch(\Exception $e){
        $this->fail('Did not expect to insert the same record set twice.');
    }

        //dd(\App\Favorite::all()->toArray());

        $this->assertCount(1, $reply->favorites);

    }
}
