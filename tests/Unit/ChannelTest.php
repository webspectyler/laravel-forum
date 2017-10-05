<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChannelTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_channel_consists_of_threads()
    {
        $channel = create('App\Channel');
        $thread = create('App\Thread');
        $thread->channel()->associate($channel)->save();
        //$this->assertInstanceOf('App\Thread', $channel->threads()->get()->first());
        $this->assertTrue($channel->threads->contains($thread));
    }
}

