    <ul class="dropdown">
        <!-- Hide this In Mobile -->
        <div class="hidden-xs">
            @if(!Auth::user())
                <div class="row">
                    @include('site.auth._login-form')
                </div>
            @else
                @include('site.auth._settings-button')
            @endif
        </div>
        <!-- mobile -->
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="visible-xs">
                        <li class="dropdown"  style="list-style-type:none ">
                            @if(!Auth::check())
                                <a type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon  glyphicon-lock"></i> &nbsp;{{ trans('word.login') }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu columns padded">
                                    @include('site.auth._login-form')
                                </ul>

                            @else
                                @include('site.auth._settings-button')
                            @endif

                        </li>
                        @include('site.partials.region')

                    </div>
                </div>
            </div>
        </div>

    </ul>
