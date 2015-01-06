@extends('site.layouts._one_column')
@section('content')

<div class="row">

    @foreach (array_chunk($posts->all(),2) as $row)

        @foreach($row as $post)
        <?php $colors = ['e67e22','2980b9','47A447']; ?>
            <div class="col-sm-6 col-md-6">
                <div class="post">
                    <div class="post-img-content">
                        <a href="{{action('BlogsController@show',$post->id) }}" >
                        @if(count($post->photos))
                            {{ HTML::image('uploads/medium/'.$post->photos[0]->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }}
                        @else
                            <img src="http://placehold.it/450x400/{{ $colors[array_rand($colors)] }}/ffffff&text={{ $post->category->name_en }}" class="img-responsive img-thumbnail" />
                        @endif
                        </a>
                    </div>
                    <div class="content">
                        <div class="post-title-wrapper">
                            <div class="post-title"><a href="{{action('BlogsController@show',$post->id) }}" >{{ $post->title }}</a></div>
                        </div>
                        <div class="post-author">

                            By <b> {{ $post->author->username }} </b>
                        </div>
                        <div class="post-description">{{ Str::limit($post->content,150) }}</div>
                        <div class="post-button"><a href="{{action('BlogsController@show',$post->id) }}" class="btn btn-primary btn-sm">Read more</a></div>
                    </div>
                </div>
            </div>
        @endforeach

    @endforeach
</div>
{{ $posts->links() }}

@stop
