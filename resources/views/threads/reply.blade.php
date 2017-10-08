            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="level">
<h5 class="flex">
                        <a href="#">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans()}}...</h5>
                        {{-- @unless (!$reply->isFavoritedBy(auth()->id())) --}}
                        <div class="">
                            <form method="POST" action="/replies/{{$reply->id}}/favorites">
                                {{ csrf_field() }}
                                <button class="btn btn-default" {{ $reply->isFavoritedBy(auth()->id()) ? 'disabled' : ''}}> {{$reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}</button>

                            </form>
                        </div>
                        {{--@endunless--}}
                    </div>
                </div>
                <div class="panel-body">

                      {{ $reply->body }}


                </div>
            </div>
