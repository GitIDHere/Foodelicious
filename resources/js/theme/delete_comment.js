$(function()
{
    var deleteComment = function(recipeId, commentId)
    {
        var deleteCommentEndpoint = APP_URL + 'api/recipe/comment';

        new Promise(function(resolve, reject)
        {
            $.ajax({
                url : deleteCommentEndpoint,
                type: "DELETE",
                accept: 'application/json',
                data: {
                    'comment': commentId,
                    'recipe': recipeId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
                .done(function(resp)
                {
                    location.reload();
                })
                .fail(function(resp)
                {
                    toastr.warning('Error deleting comment');
                })
            ;
        });
    }

   $('.comment-delete i').on('click', function()
   {
       var deleteBtn = $(this);

       var recipeId = deleteBtn.attr('data-recipe');
       var commentId = deleteBtn.attr('data-comment');

       if (confirm("Delete your comment?"))
       {
           deleteComment(recipeId, commentId);
       }

       return false;
   });
});
