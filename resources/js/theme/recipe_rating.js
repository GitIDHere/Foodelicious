$(function()
{
    $('.recipe-ratings > .ratings input#toggle-heart').on('click', function(e)
    {
        $(this).removeClass('checked');

        var endpoint = APP_URL + 'api/recipe/rating';
        var recipeId = $(this).attr('data-recipe');

        if (recipeId !== undefined)
        {
            axios.get('/sanctum/csrf-cookie').then(response =>
            {
                new Promise(function(resolve, reject){
                    $.ajax({
                        url : endpoint,
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
                        if (resp.ratings !== undefined)
                        {
                            // Animate the heart
                            $('input#toggle-heart').addClass('checked');

                            // Update the counter
                            $('.ratings .rating').text(resp.ratings);
                        }
                    })
                    ;
                });
            });
        }
    });
});
