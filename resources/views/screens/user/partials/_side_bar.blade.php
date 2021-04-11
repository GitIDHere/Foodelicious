<div class="pl-0 pt-2 col-12 col-lg-3">
    <div class="sidebar">
        <ul class="list">
            
            @php
            $routeName = \Request::route()->getName();
            $userProfileRoutes = \Illuminate\Support\Str::contains($routeName, 'user.profile');
            $recipeRoutes = \Illuminate\Support\Str::contains($routeName, 'user.recipes');
            $favouritesRoutes = \Illuminate\Support\Str::contains($routeName, 'user.favourites');
            $securityRoutes = \Illuminate\Support\Str::contains($routeName, 'user.security');
            @endphp
            
            <li class="{{ ($userProfileRoutes ? 'active' : '') }}">
                <a href="{{route('user.profile.view')}}">My profile</a>
            </li>
            
            <li class="{{ ($recipeRoutes ? 'active' : '') }}">
                <a href="{{route('user.recipes.list')}}">My recipes</a>
            </li>
            
            <li class="{{ ($favouritesRoutes ? 'active' : '') }}">
                <a href="#">Favourites</a>
            </li>

            <li class="{{ ($securityRoutes ? 'active' : '') }}">
                <a href="{{route('user.security.view')}}">Account security</a>
            </li>
        </ul>
    </div>
</div>