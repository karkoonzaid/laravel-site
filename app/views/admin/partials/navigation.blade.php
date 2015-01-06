<div class="navbar navbar-default navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li{{ (Request::is('admin/event*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/') }}}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                <li{{ (Request::is('admin/subscription*') ? ' class="active"' : '') }}><a href="{{ URL::action('AdminSubscriptionsController@index') }}"><span class="glyphicon glyphicon-lock"></span> Subscriptions</a></li>
                <li{{ (Request::is('admin/payment*') ? ' class="active"' : '') }}><a href="{{ URL::action('AdminPaymentsController@index') }}"><span class="glyphicon glyphicon-lock"></span> Payments</a></li>
                <li{{ (Request::is('admin/blogs*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/blogs') }}}"><span class="glyphicon glyphicon-list-alt"></span> Blog</a></li>
                <li{{ (Request::is('admin/category*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/category') }}}"><span class="glyphicon glyphicon-tag"></span> Category</a></li>
                <li class="dropdown{{ (Request::is('admin/users*|admin/roles*') ? ' active' : '') }}">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('admin/users') }}}">
                        <span class="glyphicon glyphicon-user"></span> Users <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-user"></span> Users</a></li>
                        <li{{ (Request::is('admin/roles*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/roles') }}}"><span class="glyphicon glyphicon-user"></span> Roles</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="glyphicon glyphicon-asterisk"></span> Settings <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li{{ (Request::is('admin/country*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/country') }}}"><span class="glyphicon glyphicon-globe"></span> Add/Edit Country</a></li>
                        <li{{ (Request::is('admin/locations*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/locations') }}}"><span class="glyphicon glyphicon-map-marker"></span> Add/Edit Locations</a></li>
                        <li{{ (Request::is('admin/comments*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/comments') }}}"><span class="glyphicon glyphicon-comment"></span> Edit Comments</a></li>
                        <li{{ (Request::is('admin/tags*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/tags') }}}"><span class="glyphicon glyphicon-tag"></span> Add/Edit Tags</a></li>
                        <li{{ (Request::is('admin/ads*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/ads') }}}"><span class="glyphicon glyphicon-pushpin"></span> Ads</a></li>
                        <li{{ (Request::is('admin/contact-us*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/contact-us') }}}"><span class="glyphicon glyphicon-envelope"></span> Edit Contact Details</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav pull-right">
                <li><a href="{{{ URL::to('/') }}}"><span class="glyphicon glyphicon-upload"></span> View Homepage</a></li>
                <li class="divider-vertical"></li>
                <li class="dropdown">
                    <ul class="dropdown-menu">
                        <li><a href="{{{ URL::to('user/'.Auth::user()->id.'/profile') }}}"><span class="glyphicon glyphicon-wrench"></span> Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="{{{ URL::to('user/logout') }}}"><span class="glyphicon glyphicon-share"></span> Logout</a></li>
                    </ul>

                </li>

            </ul>
        </div>
    </div>
</div>