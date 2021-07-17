<div class="client-header custom-header-client">
    <div class="client-header-wrap">
        <div class="fund-header-left-wrap">
            <div class="funds-header-element">
                <ul class="nav nav-tabs funds-subFunds-menu" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{$fundgroups_class}}"  href="{{ route('funds') }}" role="tab" aria-controls="home" aria-selected="true">Fund Groups</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$subfunds_class}}" href="{{ route('funds.subfunds') }}" role="tab" aria-controls="profile" aria-selected="false">Sub-Funds</a>
                    </li>
                </ul>
            </div>
           
            <div class="funds-header-searchBox">
                <input class="form-control search-on-teams search-module" type="text" placeholder="{{__('funds.view_details.Search')}}" data-search-column="fund_search" id="search-on-teams" data-url="{{$search_url}}" autocomplete="off">
            </div>
           
        </div>
        <div class="client-header-right-wrap ml-auto">
            <div class="funds-header-element">
            @can('manager-only',Auth::user())
            @if(Route::currentRouteName() == 'funds')
                <div class="search-btn"><button class="btn search fund-addnew-btn" type="button" data-toggle="modal" data-target=".add-fundgroup"> {{__('clients.view_details.ADD NEW')}}</button></div>
            @endif
            @if(Route::currentRouteName() == 'funds.subfunds')
                <div class="search-btn"><button class="btn search fund-addnew-btn" type="button" data-toggle="modal" data-target=".add-subfund">ADD NEW</button></div>
             @endif
             @endcan
            </div>
        </div>
    </div>
</div>



