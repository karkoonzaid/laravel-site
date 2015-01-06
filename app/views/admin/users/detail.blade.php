@extends('admin.layouts.print')
@section('content')
<table class=" table ">
    <tr>
        <td></td>
        <td><b>Name in English</b></td>
        <td>{{ $user->name_en ? : trans('word.not_available') }}</td>
    </tr>
    <tr>
        <td><b>Name in Arabic</b></td>
        <td>{{ $user->name_ar ? : trans('word.not_available') }}</td>
    </tr>
    <tr>
        <td><b>Username</b> </td>
        <td>{{ $user->username ? : trans('word.not_available') }}</td>
    </tr>

    <tr>
        <td><b>Email</b> </td>
        <td>{{ $user->email ? : trans('word.not_available') }}</td>
    </tr>
    <tr>
        <td><b>Phone</b> </td>
        <td>{{ $user->mobile ? : trans('word.not_available') }}</td>
    </tr>

    <tr>
        <td><b>Mobile</b> </td>
        <td>{{ $user->phone ? : trans('word.not_available') }}</td>
    </tr>
    <tr>
        <td><b>Date Registered </b> </td>
        <td>{{ $user->created_at }}</td>
    </tr>

    <tr>
        <td><b>Active </b></td>
        <td>{{ $user->active == 1 ? 'yes' : 'no' }}</td>
    </tr>

</table>

@stop