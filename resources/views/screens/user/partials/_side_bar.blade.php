<div class="pl-0 pt-2 col-12 col-lg-3">
    <div class="sidebar">
        <ul class="list">
            
            @php
            $routeName = \Request::route()->getName();
            $userProfileRoutes = \Illuminate\Support\Str::contains($routeName, 'user.profile');
            $favouritesRoutes = \Illuminate\Support\Str::contains($routeName, 'user.favourites');
            $securityRoutes = \Illuminate\Support\Str::contains($routeName, 'user.profile_security');
            @endphp
            
            <li class="{{ ($userProfileRoutes ? 'active' : '') }}">
                <a href="{{route('user.profile.view')}}">My profile</a>
            </li>

            <li class="{{ ($favouritesRoutes ? 'active' : '') }}">
                <a href="#">Favourites</a>
            </li>

            <li class="{{ ($securityRoutes ? 'active' : '') }}">
                <a href="#">Security</a>
            </li>
        </ul>
    </div>
</div>