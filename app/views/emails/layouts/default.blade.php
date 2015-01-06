@extends('emails.layouts.master')
@section('content')
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#dddad9;border-collapse:collapse">
        <tbody>
            <tr> <td style="padding:2px 18px 0px"> </td> </tr>
        </tbody>
    </table>
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin:0;padding:5px;background-color:#FFFFFF;height:100%!important;width:100%!important" width=
        "100%">
            <tbody>
                <tr>
                    <tr>
                        <td style="padding:30px 25px;color:#696969;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:18px;text-align:left;line-height:150%;font-weight: normal;" valign="top">
                            <strong>
                            @section('body')
                            @show
                            </strong><br>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:9px 18px;color:#696969;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:18px;text-align:right;line-height:150%" valign="top">
                            <strong>- Kaizen For Conferences & Exhibitions</strong>
                        </td>
                    </tr>

                </tr>
            </tbody>
        </table>
    @stop