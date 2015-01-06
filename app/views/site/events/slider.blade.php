<div class="row">
    <div class="col-md-12">

        @if(isset($events))
            <div class="col-md-3 hidden-xs hidden-sm">
                <?php $i = 0; ?>
                @foreach($events as $event)
                    <span class="tag tag-gray {{ ($i == 0) ? 'active-tab-slide' : '' }}" id="slide{{ $i }}" style="cursor: pointer; font-size: 15px;">
                    @if ( App::getLocale() == 'en')
                        {{  ($event->title_en ) ? $event->title_en  : $event->title_ar  }}
                    @else
                        {{   $event->title_ar  }}
                    @endif
                    </span>
                    <?php $i ++; ?>
                @endforeach
            </div>

            <div id="myCarousel" class="carousel slide col-md-9 col-xs-12 top5" data-ride="carousel">

                <ol class="carousel-indicators" style="display: none;">
                    <?php $i = 0; ?>
                    @foreach($events as $event)
                        <li data-target="#myCarousel" data-slide-to="{{ $i }}" {{ ($i == 0) ? 'class="active"' : '' }} ></li>
                        <?php $i ++; ?>
                    @endforeach
                </ol>

                <div class="carousel-inner ">
                    <?php $char_limit = 100; ?>
                    <?php $first = "active"; $order = 0;?>
                    @foreach ($events as $event)
                        <div class="slider item {{$first}}" data-order="{{$order}}">
                            <a href="{{ action('EventsController@show',$event->id) }}"> {{ HTML::image('uploads/medium/'.$event->name.'','image2',array('class'=>'img-responsive','style'=>'width:62%;height:auto')) }} </a>

                            @if ( App::getLocale() == 'en')
                                <div class="carousel-caption hidden-xs">
                                    <span class="slider-title {{ ($event->title_en) ? 'text-left':'text-right' }}">
                                        <a href="{{ action('EventsController@show',$event->id) }}">
                                            {{  ($event->title_en ) ? $event->title_en  : $event->title_ar  }}
                                        </a>
                                    </span>
                                    <span class="slider-description {{ ($event->description_en) ? 'text-left':'text-right' }}">
                                            {{{ ($event->description_en) ? Str::limit(strip_tags($event->description_en),$char_limit) : Str::limit(strip_tags($event->description_ar),$char_limit) }}}
                                    </span>
                                    <a class="kaizen-button" href="{{ action('EventsController@show',$event->id) }}">
                                        {{ ($event->button_en) ? $event->button_en : $event->button_ar }}
                                    </a>
                                </div>
                            @else
                                <div class="carousel-caption hidden-xs">
                                    <span class="slider-title {{ ($event->title_en) ? 'text-left':'text-right' }}">
                                        <a href="{{ action('EventsController@show',$event->id) }}" class="top15">
                                            {{  $event->title_ar }}
                                        </a>
                                    </span>
                                    <span class="slider-description {{ ($event->description_en) ? 'text-left':'text-right' }}">
                                            {{ Str::limit(strip_tags($event->description_ar),$char_limit) }}
                                    </span>
                                    <a class="btn btn-info kaizen-button" href="{{ action('EventsController@show',$event->id) }}">
                                        {{ $event->button_ar }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <?php $first = ""; $order ++;?>
                    @endforeach
                </div>

                <ol class="carousel-indicators">
                    <?php $first = "active";?>
                    @if($events)
                        @for($i =0; $i < count($events); $i++)
                            <li data-target="#myCarousel" data-slide-to="{{$i}}" class="{{$first}}" style="display: none;"></li>
                            <?php $first = "";?>
                        @endfor
                    @endif
                </ol>
            </div>
        @endif
    </div>
</div>

</br>

