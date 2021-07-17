<div class="client-header custom-header-client">
    <div class="client-header-wrap">
        <div class="client-header-left-wrap px-4">
            <div class="client-header-element">
                <a  class="{{$department_class ?? ''}}" data-content-type="departments">{{__('clients.view_details.Clients')}}</a>
            </div>
            <div class="client-header-searchBox">
                <input class="form-control search-module" type="text" placeholder="{{__('clients.view_details.Search')}}" data-search-column="client_search" id="search-on-teams" data-url="{{$search_url}}" autocomplete="off">
            </div>
        </div>
        @can('manager-only',Auth::user())
        <div class="client-header-right-wrap ml-auto">
            <div class="client-header-element">
                <div class="search-btn"><button class="btn search client-addnew-btn" type="button" data-toggle="modal" data-target=".add-department"> {{__('clients.view_details.ADD NEW')}}</button></div>
            </div>
        </div>
        @endcan
    </div>
</div>