<div id="side-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ Lang::get('word.newsletter') }}
        </div>
        <div class="panel-body">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::open(array('action'=>'NewslettersController@subscribe')) }}
                    <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </span>
                        {{Form::input('email','email',NULL,array('class'=>'form-control','placeholder'=>trans('word.email') ,'required'=>'"required"'))}}
                            <span class="input-group-btn">
                                <button id="submit" class="btn btn-primary" type="submit"><i class="fa fa-arrow-left fa-fw"></i> </button>
                            </span>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>