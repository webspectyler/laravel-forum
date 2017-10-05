<?php

namespace Tests\Feature;

use Tests\TestCase;
#use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function a_user_can_browse_threads()
    {
        $response = $this->get('/threads')
            ->assertSee($this->thread->title);
        //$response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_view_a_single_thread()
    {
        $this->get('/threads/'. $this->thread->channel->slug . '/'.  $this->thread->id)
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_replies_that_are_associated_with_a_thread()
    {
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);

        $this->get('/threads/'. $this->thread->channel->slug . '/' . $this->thread->id)
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel(){
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread');
        $threadInChannel->channel()->associate($channel)->save();

        $threadNotInChannel = create('App\Thread');
        //$channel_2 = create('App\Channel');
        //$threadNotInChannel->channel()->associate($channel_2)->save();

        $response = $this->get("/threads/{$channel->slug}/")
             ->assertSee($threadInChannel->title)
             ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username(){
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));
        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');

        $response = $this->get('/threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity(){
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $response = $this->getJson('threads?popular=1')->json();
        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
    }

}
