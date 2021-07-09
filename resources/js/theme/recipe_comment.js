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
                        // Update the current rating number
                        if (textStatus === 'success')
                        {
                            window.location.href = '#comments';
                            location.reload();
                        }
                    })
                    .fail(function(resp)
                    {
                        toastr.warning('Error posting comment');
                    })
                ;
            });
        });

        e.preventDefault();

    });

});
