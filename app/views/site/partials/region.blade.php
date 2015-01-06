
    <div class="intl-tel-input">
        <div class="visible-xs top10"></div>
        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            <img src="" class="flag {{strtolower($selectedCountry)}}"/><span class="country-name">{{ $selectedCountry }}</span><span class="caret"></span>
        </a>

        <ul class="dropdown-menu" role="menu">
            @foreach($availableCountries as $country )
                <li><a href="{{ action('LocaleController@setCountry',['country'=> $country->iso_code]) }}"><img src="" class="flag {{strtolower($country->iso_code)}}"/><span class="country-name">{{$country->name}}</span></a></li>
            @endforeach
        </ul>
    </div>
