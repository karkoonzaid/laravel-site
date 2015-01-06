<table class="table table-striped">
     <tr>
         <td>{{ trans('auth.signup.name_en') }} : </td>
         <td>{{ $user->name_en ? $user->name_en : trans('word.not_available') }}</td>
     </tr>
     <tr>
         <td>{{ trans('auth.signup.name_ar') }} : </td>
         <td>{{ $user->name_ar ? $user->name_ar: trans('word.not_available') }}</td>
     </tr>
     <tr>
         <td>{{ trans('word.email') }} : </td>
         <td>{{ $user->email ? $user->email: trans('word.not_available') }}</td>
     </tr>
     <tr>
         <td>{{ trans('word.mobile') }} : </td>
         <td>{{ $user->mobile ? $user->countrycode.$user->mobile: trans('word.not_available') }}</td>
     </tr>
     <tr>
         <td>{{ trans('word.phone') }} : </td>
         <td>{{ $user->phone ? $user->countrycode.$user->phone: trans('word.not_available') }}</td>
     </tr>
     <tr>
         <td>{{ trans('word.country') }} : </td>
         <td>{{ $user->country ? $user->country: trans('word.not_available') }}</td>
     </tr>
     <tr>
         <td>{{ trans('word.gender') }} : </td>
         <td>{{ $user->gender ? trans('word.'.strtolower($user->gender)): trans('word.not_available') }}</td>
     </tr>
     <tr>
         <td>{{ trans('word.instagram') }} : </td>
         <td>{{ $user->instagram ? $user->instagram: trans('word.not_available') }}</td>
     </tr>
     <tr>
         <td>{{ trans('word.twitter') }} : </td>
         <td>{{ $user->twitter ? $user->twitter: trans('word.not_available') }}</td>
     </tr>
 </table>