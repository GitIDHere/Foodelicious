$(function()
{
    $('.recipe-ratings > .ratings > i').on('click', function()
    {
        var endpoint = APP_URL + 'api/recipe/rating';
        var recipeId = $(this).attr('data-recipe');

        if (recipeId !== undefined)
        {
            return new Promise(function(resolve, reject){
                $.ajax({
                    url : endpoint,
                    type: "POST",
                    accept: 'application/json',
                    data: {'recipe': recipeId},
                })
                    .done(function(resp)
                    {
                        // Update the current rating number
                        if (resp.data !== undefined)
                        {
                            console.log(resp.data);
                        }
                    })
                    .fail(function(sd){
                        console.log(sd);
                    })
                ;
            });
        }
    });
});
