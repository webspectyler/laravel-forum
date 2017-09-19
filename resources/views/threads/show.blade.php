@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  {{ $thread->creator->name}} posted
                  {{ $thread->title}}</div>

                <div class="panel-body">
                  
                   <article>
                      
                      <div class="body">{{ $thread->body }}</div>
                      <hr />
                   </article>
                   
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <h3>Replies</h3>
          @foreach ($thread->replies as $reply)
          @include ('threads.reply')
            @endforeach
        </div>
    </div>
    @if (auth()->check())
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <form method="POST" action="{{ $thread->path() . '/replies' }}">
            {{ csrf_field() }}
            <div class="form-group">
              <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
            </div>
            <div class="form-group"><button type="submit" class="btn btn-default">Post</button></div>
          </form>
        </div>
    </div>
    @else
      <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
    @endif

</div>
@endsection
