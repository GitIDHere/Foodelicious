<div class="sidebar">
    <ul class="list">
        @php
        $routeName = \Request::route()->getName();
        $userProfileRoutes = \Illuminate\Support\Str::contains($routeName, 'user.profile');
        $recipeRoutes = \Illuminate\Support\Str::contains($routeName, 'user.recipes');
        $favouritesRoutes = \Illuminate\Support\Str::contains($routeName, 'user.recipe.favourites');
        @endphp

        <li class="{{ ($userProfileRoutes ? 'active' : '') }}">
            <a href="{{route('user.profile.view')}}">My profile</a>
        </li>

        <li class="{{ ($recipeRoutes ? 'active' : '') }}">
            <a href="{{route('user.recipes.list')}}">My recipes</a>
        </li>

        <li class="{{ ($favouritesRoutes ? 'active' : '') }}">
            <a href="{{route('user.recipe.favourites')}}">Favourite Recipes</a>
        </li>
    </ul>
</div>
