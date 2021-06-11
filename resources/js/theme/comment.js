$(function()
{
    var commentAPIEndpoint = APP_URL + 'api/recipe/comment';

    $('#recipe-comment').on('submit', function(e)
    {
        var commentTxtarea = $(this).find('#comment');
        var comment = commentTxtarea.val();
        var recipe = $(this).attr('data-recipe');

        // Send to API endpoint
        axios.get('/sanctum/csrf-cookie').then(response =>
        {
            var commentData = {
                'comment': comment,
                'recipe': Number(recipe)
            };

            new Promise(function(resolve, reject){
                $.ajax({
                    url : commentAPIEndpoint,
                    type: "POST",
                    accept: 'application/json',
                    data: commentData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                    .done(function(resp, textStatus)
                    {
                        console.log(textStatus);
                        // Update the current rating number
                        if (textStatus === 'success')
                        {
                            //Remove all text from comments
                            $(commentTxtarea).val('');

                            toastr.info('Comment posted!');
                        }
                    })
                    .fail(function(resp)
                    {
                        if(resp.status === 409)
                        {
                            // Show toast
                            toastr.warning('You have already commented on this recipe.');
                        }
                        else {
                            // Show toast
                            toastr.warning('Error posting comment');
                        }
                    })
                ;
            });
        });

        e.preventDefault();

    });


});
