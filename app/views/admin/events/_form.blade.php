<div class="row">
    <div class="form-group col-md-6 col-md-offset-3 free">
        <h2>{{ Form::label('free_event', 'Free Event ?:') }}
            {{ Form::hidden('free', 0); }}
            {{ Form::checkbox('free', '1', true) }}</h2>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('date_start', 'Event Start Date:') }}
        <div class="input-group">
            {{ Form::text('date_start',null,array('class'=>'form-control')) }}
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('date_end', 'Event End Date:') }}
        <div class="input-group">
            {{ Form::text('date_end',null,array('class'=>'form-control')) }}
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4">
        {{ Form::label('user_id', 'Trainer:',array('class'=>'control-label')) }}
        {{ Form::select('user_id', $author,null,array('class'=>'form-control')) }}
    </div>

    <div class="form-group col-md-4">
        {{ Form::label('category_id', 'Category:') }}
        {{ Form::select('category_id', $category,null,array('class'=>'form-control')) }}
    </div>

    <div class="form-group col-md-4">
        {{ Form::label('location_id', 'Location:') }}
        {{ Form::select('location_id', $location,null,array('class'=>'form-control')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('title_en', 'Title in English:') }}
        {{ Form::text('title_en',null,array('class'=>'form-control')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('title_ar', 'Title in Arabic:*') }}
        {{ Form::text('title_ar',null,array('class'=>'form-control right')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('description_en', 'Description in English:') }}
        {{ Form::textarea('description_en',null,array('class'=>'form-control wysihtml5')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('description_ar', 'Description in Arabic:*') }}
        {{ Form::textarea('description_ar',null,array('class'=>'form-control wysihtml5 right', 'id'=>'description_ar')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('Phone', 'Phone:') }}
        <div class="input-group">
            {{ Form::text('phone',null,array('class'=>'form-control')) }}
            <span class="input-group-addon">
                <i class="fa fa-phone"></i>
            </span>
        </div>
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('email', 'Email:') }}
        <div class="input-group">
            {{ Form::text('email',null,array('class'=>'form-control')) }}
            <span class="input-group-addon">
                <i class="fa fa-envelope"></i>
            </span>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('address_en', 'Address in English:') }}
        {{ Form::text('address_en',null,array('class'=>'form-control')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('address_ar', 'Address in Arabic:*') }}
        {{ Form::text('address_ar',null,array('class'=>'form-control right')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('street_en', 'Street Name in English:') }}
        {{ Form::text('street_en',null,array('class'=>'form-control')) }}
    </div>

    <div class="form-group col-md-6">
        {{ Form::label('street_ar', 'Street Name in Arabic:*') }}
        {{ Form::text('street_ar',null,array('class'=>'form-control right')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        <div class="map-wrapper">
            <div id="map" style="height: 400px;"></div>
            <div class="small">You can drag and drop the marker to the correct location</div>
            <input id="addresspicker_map" name="addresspicker_map" class="form-control" placeholder="Type the Street Address or drag and drop the map marker to the correct location">
            {{ Form::hidden('latitude',null, array('id' => 'latitude')) }}
            {{ Form::hidden('longitude',null, array('id' => 'longitude')) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('button_ar', 'Event Button Text in Arabic:') }}
        {{ Form::text('button_ar','سجل',array('class'=>'form-control')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('button_en', 'Event Button Text English:') }}
        {{ Form::text('button_en','Register',array('class'=>'form-control')) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('button_en', 'Is this a Featured Event ? : (Featured Event Will be included in Slider)') }}
        <br>
        {{ Form::checkbox('featured', '1', false) }}
    </div>
</div>

@if(isset($_GET['package_id']))
    {{ Form::hidden('package_id', $_GET['package_id']) }}
@endif