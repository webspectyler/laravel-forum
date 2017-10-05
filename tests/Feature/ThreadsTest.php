<?php

namespace Tests\Feature;

use Tests\TestCase;
#use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_browse_threads()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads');

        $response->assertSee($thread->title);
        //$response->assertStatus(200);


    }

    /** @test */
    public function a_user_can_view_a_single_thread()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads/'. $thread->channel->slug . '/' .  $thread->id);

        $response->assertSee($thread->title);
    }
}
