<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Home > My Profile
Breadcrumbs::for('my_profile', function ($trail) {
    $trail->parent('home');
    $trail->push('My Profile', route('user.profile.view'));
});

// Home > My Profile > Update details
Breadcrumbs::for('profile_details', function ($trail) {
    $trail->parent('my_profile');
    $trail->push('Update Details', route('user.profile.details'));
});

// Home > My Recipes
Breadcrumbs::for('recipes_list', function ($trail) {
    $trail->parent('home');
    $trail->push('My Recipes', route('user.recipes.list'));
});

// Home > My Recipes > New Recipe
Breadcrumbs::for('new_recipe', function ($trail) {
    $trail->parent('recipes_list');
    $trail->push('New Recipe', route('user.recipes.create.view'));
});

// Home > My Recipes > {recipe}
Breadcrumbs::for('edit_recipe', function ($trail, $recipe) 
{
    $shortTitle = \Illuminate\Support\Str::limit($recipe->title, 25);
    $trail->parent('recipes_list');
    $trail->push($shortTitle, route('user.recipes.view', $recipe));
});





// Home > Account Security
Breadcrumbs::for('account_security', function ($trail) {
    $trail->parent('home');
    $trail->push('Account Security', route('user.security.view'));
});

// Home > Account Security > Update Password
Breadcrumbs::for('update_password', function ($trail) {
    $trail->parent('account_security');
    $trail->push('Update Password', route('user.security.password.view'));
});

// Home > Account Security > Update email
Breadcrumbs::for('update_email', function ($trail) {
    $trail->parent('account_security');
    $trail->push('Update Email', route('user.security.email.view'));
});

