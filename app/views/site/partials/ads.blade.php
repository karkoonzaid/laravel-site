<!-- Advertisment section-->
<div class="row">
    <div class="col-md-12 adsWrapper hidden-sm hidden-xs">
        @if($ads)
            @foreach($ads as $ad)
                <div class="col-md-6">
                    <div class="ads" >
                        <a href="{{ $ad->url }}" title="{{ $ad->tilte }}" alt="{{ $ad->title }}" target="_blank" >{{ HTML::image('uploads/thumbnail/'.$ad->photos[0]->name.'','image1',array('class'=>'img-responsive')) }}</a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
