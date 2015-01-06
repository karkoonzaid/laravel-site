<!-- template start -->
<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="border-collapse:collapse;margin:0;padding:0;background-color:#dddad9;height:100%!important;width:100%!important">
    <tbody>
        <tr>
            <td align="center" valign="top" style="margin:0;padding:20px;border-top:0;height:100%!important;width:100%!important">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse:collapse;border:0">
                    <tbody>
                        <tr>
                            <td align="center" valign="top">
                                <!-- header section -->
                                @include('emails.layouts.header')
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top">
                                @section('content')
                                @show
                                @include('emails.layouts.footer')
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
