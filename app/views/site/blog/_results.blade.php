<div class="col-md-12" style="padding: 20px; border:1px solid white ; margin-bottom: 20px; background-color: #ececec !important;">

            <div class="col-md-3">
                @if(count($post->photos))
                    {{ HTML::image('uploads/medium/'.$post->photos[0]->name.'','image1',array('class'=>'img-responsive img-thumbnail')) }}
                @else
                <a href="{{action('BlogsController@show',$post->id) }}">
                    @if($post->category)
                        <img src="http://placehold.it/100x100/2980b9/ffffff&text={{ $post->category->name }}" class="img-responsive img-thumbnail" />
                    @endif
                </a>
                @endif
            </div>

            <div class="col-md-8">
                <div class="row">
                 <div class="col-md-12">
                <h4><strong><a href="{{action('BlogsController@show',$post->id) }}">{{ $post->title }}</a></strong></h4>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p style="width: 98%;">
                            {{ Str::limit(strip_tags($post->description), 100) }}
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pull-left">
                        @if($post->author)
                        <i class="glyphicon glyphicon-user"></i> by <span class="muted">{{{ $post->author->username }}}</span> |
                        @endif
                        <i class="glyphicon glyphicon-calendar"></i> <!--Sept 16th, 2012-->{{{ $post->created_at }}}
                        <a class="btn-sm btn-mini btn-info pull-left" href="{{action('BlogsController@show',$post->id) }}">{{trans('word.more')}}</a>
                    </div>
                </div>

            </div>


        </div>