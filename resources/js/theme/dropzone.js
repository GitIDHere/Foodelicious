window.Dropzone.autoDiscover = false;
window.Dropzone.default.autoDiscover = false;

$(function()
{
    var recipeId = $('#recipe-form').attr('data-recipe');
    var photoEndpoint = APP_URL + 'api/'+recipeId+'/photos';

    $("#recipe_dropzone").dropzone({
        url: photoEndpoint,
        uploadMultiple: false,
        autoDiscover: false,
        paramName: "photos", // The name that will be used to transfer the file
        maxFilesize: 2, // MB
        maxFiles: 4,
        addRemoveLinks: true,
        dictDefaultMessage: "Click here to upload your recipe photos.<br/><small>(Maximum 4 photos)</small>",
        dictFallbackText: "Please use the button below to upload your recipe photos",
        //autoProcessQueue: false,
        //autoQueue: false,
        //forceFallback: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        removedfile: function (file)
        {
            $.ajax({
                url : photoEndpoint,
                type: "DELETE",
                accept: 'application/json',
                data: {"id": file.id},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .done(function(resp, textStatus)
            {
                toastr.info('Photo deleted');
            })
            .fail(function(resp)
            {
                toastr.warning('Error deleting photo');
            });

            // Remove the thumbnail from the Dropzone HTML element
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        },
        success: function(file, response)
        {
            file.id = response[0];
            toastr.info('Photo successfully uploaded');
        },
        error: function(file, message)
        {
            toastr.warning('Error uploading photo');
            $(file.previewElement).addClass("dz-error");
        },
    });

});
