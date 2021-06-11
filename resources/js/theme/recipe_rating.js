$(function()
{
    $('.recipe-favourites > .favourites input#toggle-heart').on('click', function(e)
    {
        $(this).removeClass('checked');

        var favouriteAPIEndpoint = APP_URL + 'api/recipe/favourite';
        var recipeId = $(this).attr('data-recipe');

        if (recipeId !== undefined)
        {
            axios.get('/sanctum/csrf-cookie').then(response =>
            {
                new Promise(function(resolve, reject){
                    $.ajax({
                        url : favouriteAPIEndpoint,
                        type: "POST",
                        accept: 'application/json',
                        data: {'recipe': recipeId},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .done(function(resp)
                    {
                        // Update the current rating number
                        if (resp.favourites !== undefined)
                        {
                            // Animate the heart
                            $('input#toggle-heart').addClass('checked');

                            // Update the counter
                            $('.favourites .favourite').text(resp.favourites);
                        }
                    })
                    .fail(function(resp){

                        if (resp.status === 401) {
                            toastr.warning('Please register and login');
                        }
                        else {
                            toastr.warning('Problem favouriting recipe');
                        }
                    })
                    ;
                });
            });
        }
    });
});
