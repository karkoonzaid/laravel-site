@extends('admin.master')

{{-- Content --}}
@section('content')

	{{-- Create User Form --}}
    <div class="row">

    </div>
	{{ Form::open(['action' => 'AdminUsersController@store', 'method' => 'post', 'class'=>'form']) }}

        <div class="form-group">
            <div class="row">
                <label class="col-md-2 control-label" for="username">Name in Arabic</label>
                <div class="col-md-10">
                    {{ Form::text('name_ar',NULL,array('class' => 'form-control ')) }}
                </div>
            </div>
        </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-2 control-label" for="username">Name in English</label>
                    <div class="col-md-10">
                        {{ Form::text('name_en',NULL,array('class' => 'form-control ')) }}
                    </div>
                </div>
            </div>

        <div class="form-group">
            <div class="row">
                <label class="col-md-2 control-label" for="username">Username</label>
                <div class="col-md-10">
                    {{ Form::text('username',NULL,array('class' => 'form-control ')) }}
                </div>
            </div>
        </div>
        <!-- ./ username -->

        <!-- Email -->
        <div class="form-group ">
            <div class="row">

                <label class="col-md-2 control-label" for="email">Email</label>
                <div class="col-md-10">

                    {{ Form::text('email',NULL,array('class' => 'form-control ')) }}

                </div>
            </div>

        </div>
        <!-- ./ email -->

        <!-- Password -->
        <div class="form-group">
            <div class="row">

                <label class="col-md-2 control-label" for="password">Password</label>
                <div class="col-md-10">
                    {{ Form::password('password',array('class' => 'form-control ')) }}
                </div>
            </div>
        </div>
        <!-- ./ password -->

        <!-- Password Confirm -->
        <div class="form-group ">
            <div class="row">

                <label class="col-md-2 control-label" for="password_confirmation">Password Confirm</label>
                <div class="col-md-10">
                    {{ Form::password('password_confirmation',array('class' => 'form-control ')) }}
                </div>
            </div>
        </div>
        <!-- ./ password confirm -->

        <!-- Password Confirm -->
        <div class="form-group ">
            <div class="row">
                <label class="col-md-2 control-label" for="mobile">Mobile</label>
                <div class="col-md-10">
                    {{ Form::text('mobile',NULL,array('class'=>'form-control ')) }}
                </div>
            </div>
        </div>
        <!-- ./ password confirm -->

        <!-- Activation Status -->
        <div class="form-group ">
            <div class="row">
                <label class="col-md-2 control-label" for="confirm">Activate User?</label>
                <div class="col-md-10 text-left">
                    @if ($mode == 'create')
                        <select class="form-control" name="active" id="active">
                            <option value="1"{{{ (Input::old('active', 0) === 1 ? ' selected="selected"' : '') }}}>Yes</option>
                            <option value="0"{{{ (Input::old('active', 0) === 0 ? ' selected="selected"' : '') }}}>No</option>
                        </select>
                    @else
                        <select class="form-control" {{{ ($user->id === Confide::user()->id ? ' disabled="disabled"' : '') }}} name="confirm" id="confirm">
                            <option value="1"{{{ ($user->active ? ' selected="selected"' : '') }}}>Yes</option>
                            <option value="0"{{{ ( ! $user->active ? ' selected="selected"' : '') }}}>No</option>
                        </select>
                    @endif
                </div>
            </div>
        </div>
        <!-- ./ activation status -->

        <!-- Groups -->
        <div class="form-group ">
            <div class="row">
                <label class="col-md-2 control-label" for="roles">Roles</label>
                <div class="col-md-6">
                    <select class="form-control" name="roles[]" id="roles[]" multiple>
                            <option value="" selected="selected">none</option>

                            @foreach ($roles as $role)
                                @if ($mode == 'create')
                                    <option value="{{{ $role->id }}}"{{{ ( in_array($role->id, $selectedRoles) ? ' selected="selected"' : '') }}}>{{{ $role->name }}}</option>
                                @else
                                    <option value="{{{ $role->id }}}"{{{ ( array_search($role->id, $user->currentRoleIds()) !== false && array_search($role->id, $user->currentRoleIds()) >= 0 ? ' selected="selected"' : '') }}}>{{{ $role->name }}}</option>
                                @endif
                            @endforeach
                    </select>

                    <span class="help-block">
                        Select a group to assign to the user, remember that a user takes on the permissions of the group they are assigned.
                    </span>
                </div>
            </div>

        </div>
        <!-- ./ groups -->

		<!-- Form Actions -->
		<div class="form-group">
		    <div class="row">
                <div class="col-md-offset-2 col-md-10">
                    <element class="btn-cancel close_popup">Cancel</element>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-success">OK</button>
                </div>
		    </div>

		</div>
		<!-- ./ form actions -->
	{{ Form::close() }}
@stop