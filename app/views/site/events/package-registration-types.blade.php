<!-- Extends From Two Column Layou -->
@extends('site.layouts._one_column')

<!-- Content Section -->
@section('content')
    @parent
    <style>
         .panel-body {
            background-color: white !important;
            border-radius: 0px !important;
            background-image: none;
        }
        .panel-heading {
            border: none !important;
            background-color: transparent;

        }
        .parent_panel > .panel-body {
            border: 4px solid #462878;
        }
        .parent_panel > .panel-heading {
            width: 167%;
            border: none;
        }
        .separator {
            border: 1px solid  #462878;
        }
        .lower-panel {
            background-color: #462878;
            padding: 15px;
        }
    </style>

    @if($vip)
        <div class="col-md-4" >
            <div class="panel panel-default parent_panel">
                <div class="panel-heading">
                   {{ strtoupper(Lang::get('site.vip'))  }}
                </div>
                <div class="panel-body" >
                    <div class="col-md-12">
                        <div class="form-group">
                            <p>
                                <span class="mute"> {{ $setting->vip_description }}</span>
                                <hr class="separator">
                            </p>

                            <!-- show for only package subscription view -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                       <span class="input-group-addon beautiful"> <input type="checkbox"> </span>
                                       <input type="text" class="form-control" disabled value="{{ Lang::get('site.newsletter_subscribe') }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                       <hr class="separator">
                       <p> <h3 class="text-center">Price {{ $setting->vip_price }} KD</h3></p>
                    </div>

                    <span class="col-md-12 lower-panel">
                       <button type="button" class="btn btn-default btn-block"> {{ Lang::get('site.subscribe') }}</button>
                    </span>

                </div>
            </div>

        </div>
    @endif

    @if($online)
        <div class="col-md-4" >
            <div class="panel panel-default parent_panel">
                <div class="panel-heading">
                   {{ strtoupper(Lang::get('site.vip'))  }}
                </div>
                <div class="panel-body" >
                    <div class="col-md-12">
                        <div class="form-group">
                            <p>
                                <span class="mute"> {{ $setting->vip_description }}</span>
                                <hr class="separator">
                            </p>

                            <!-- show for only package subscription view -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group">
                                       <span class="input-group-addon beautiful"> <input type="checkbox"> </span>
                                       <input type="text" class="form-control" disabled value="{{ Lang::get('site.newsletter_subscribe') }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                       <hr class="separator">
                       <p> <h3 class="text-center">Price {{ $setting->vip_price }} KD</h3></p>
                    </div>

                    <span class="col-md-12 lower-panel">
                       <button type="button" class="btn btn-default btn-block"> {{ Lang::get('site.subscribe') }}</button>
                    </span>

                </div>
            </div>

        </div>


    @endif

    <!-- Normal -->
    <div class="col-md-4" >
         <div class="panel panel-default parent_panel">
             <div class="panel-heading">
                {{ strtoupper(Lang::get('site.normal'))  }}
             </div>
             <div class="panel-body" >
                 <div class="col-md-12">
                     <div class="form-group">
                         <p>
                             <span class="mute"> {{ $event->description }}</span>
                             <hr class="separator">
                         </p>

                         <!-- show for only package subscription view -->
                         <div class="row">
                             <div class="col-lg-12">
                                 <div class="input-group">
                                    <span class="input-group-addon beautiful"> <input type="checkbox"> </span>
                                    <input type="text" class="form-control" disabled value="{{ Lang::get('site.newsletter_subscribe') }}">
                                 </div>
                             </div>
                         </div>

                     </div>
                 </div>

                 <div class="col-md-12">
                    <hr class="separator">
                    <p> <h3 class="text-center">Price {{ $event->price }} KD</h3></p>
                 </div>

                 <span class="col-md-12 lower-panel">
                    <button type="button" class="btn btn-default btn-block"> {{ Lang::get('site.subscribe') }}</button>
                 </span>

             </div>
         </div>

     </div>



@stop