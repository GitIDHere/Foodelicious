<div class="sidebar">
    <ul class="list">
        @php
        $routeName = \Request::route()->getName();
        $userProfileRoutes = \Illuminate\Support\Str::contains($routeName, 'user.profile');
        $favouritesRoutes = \Illuminate\Support\Str::contains($routeName, 'user.favourites');
        $securityRoutes = \Illuminate\Support\Str::contains($routeName, 'user.security');
        @endphp

        <li class="{{ ($userProfileRoutes ? 'active' : '') }}">
            <a href="{{route('user.profile.view')}}">My profile</a>
        </li>

        <li class="{{ ($favouritesRoutes ? 'active' : '') }}">
            <a href="#">Favourites</a>
        </li>

        <li class="{{ ($securityRoutes ? 'active' : '') }}">
            <a href="{{route('user.security.view')}}">Account security</a>
        </li>
    </ul>
</div>
