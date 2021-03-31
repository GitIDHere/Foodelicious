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

// Home > My Profile > New Recipe
Breadcrumbs::for('new_recipe', function ($trail) {
    $trail->parent('my_profile');
    $trail->push('New Recipe', route('user.recipes.create.view'));
});

// Home > My Profile > {recipe}
Breadcrumbs::for('edit_recipe', function ($trail, $recipe) {
    $trail->parent('my_profile');
    $trail->push('Edit Recipe', route('user.recipes.view', $recipe));
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

