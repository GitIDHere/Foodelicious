$(function()
{
    var contactCommentEndpoint = APP_URL + 'api/contact/comment';

    $('form#contact').on('submit', function(e)
    {
        var comment = $(this).find('#comment');
        var name = $(this).find('#name');
        var email = $(this).find('#email');

        // Send to API endpoint
        axios.get('/sanctum/csrf-cookie').then(response =>
        {
            new Promise(function(resolve, reject){
                $.ajax({
                    url : contactCommentEndpoint,
                    type: "POST",
                    accept: 'application/json',
                    data: {
                        'comment': comment.val(),
                        'name': name.val(),
                        'email': email.val(),
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .done(function(resp, textStatus)
                {
                    // Update the current rating number
                    if (textStatus === 'success')
                    {
                        comment.val('');
                        name.val('');
                        email.val('');

                        toastr.success('Comment has been sent!');
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
