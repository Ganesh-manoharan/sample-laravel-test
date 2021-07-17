<div class="teams-header">
    <div class="teams-header-wrap">
        <div class="teams-header-left-wrap px-4">
            <div class="teams-header-element">
                <a href="{{route('teams')}}" class="{{$department_class}}" data-type="department">{{__('teams.dashboard.Departments')}}</a>
            </div>
            <div class="teams-header-element text-left">
                <a href="{{route('teams.allusers')}}" class="{{$users_class}}" data-type="user">{{__('teams.dashboard.All Users')}}</a>
            </div>
        </div>
        <div class="teams-header-right-wrap">
            <div class="teams-header-element">
                <input class="form-control search-module" type="text" placeholder="Search" data-search-column="teams_search" id="search-on-teams" data-url="{{$search_url}}" autocomplete="off">
            </div>
            
            @can('manager-only',Auth::user())
            <div class="teams-header-element pr-4">
                <div class="search-btn">
                    <button class="btn search get-data-for-adding" type="button" data-toggle="modal" data-target="#{{$add_button}}">{{__('teams.dashboard.ADD NEW')}}</button>
                </div>
            </div>
            @endcan
        </div>
    </div>
</div>