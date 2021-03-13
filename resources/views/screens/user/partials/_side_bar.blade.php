<div class="pl-0 col-12 col-lg-3">
    <div class="sidebar">
        <ul class="list">
            
            <li class="{{ Route::is('user.profile.view') ? 'active' : '' }}">
                <a href="{{route('user.profile.view')}}">My profile</a>
            </li>
            
            <li class="{{ Route::is('user.recipes.list') ? 'active' : '' }}">
                <a href="{{route('user.recipes.list')}}">My recipes</a>
            </li>
            
            <li class="{{ Route::is('user.profile.favourites') ? 'active' : '' }}">
                <a href="#">Favourites</a>
            </li>
        </ul>
    </div>
</div>