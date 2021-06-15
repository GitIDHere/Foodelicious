
@if(isset($comments))
    <div id="comments" class="slidetxt mb-5">

        @if (session()->has('comment-toast'))
            <div class="render-toast info">{{session('comment-toast')}}</div>
        @endif

        <h3 class="overview"><a href="#" class=""><i class="fa fa-comment"></i> {{$comments['total'] .' '. \Illuminate\Support\Str::plural('comment', $comments['total'])}}</a></h3>

        <div class="slidetxtinner">

            @foreach($comments['comments'] as $comment)
                <div class="comment">
                    <div class="comment-info">
                        <span class="comment-username">{{$comment['username']}} - {{$comment['date']}}</span>
                        @if ($comment['allow_delete'])
                            <span class="comment-delete right"><i class="fa fa-trash" data-comment="{{$comment['id']}}" data-recipe="{{$comment['recipe_id']}}" ></i></span>
                        @endif
                    </div>
                    <p>{{$comment['comment']}}</p>
                </div>
            @endforeach

            {{ $comments['pager']->fragment('comments')->links('includes.pagination') }}

        </div>

    </div>
@endif
