window.Dropzone.autoDiscover = false;
window.Dropzone.default.autoDiscover = false;

$(function()
{
    var recipeId = $('#recipe-form').attr('data-recipe');

    var endpoint = APP_URL + 'api/';
    if (isNaN(recipeId)) {
        endpoint += 'recipe/create/';
    }
    endpoint += recipeId + '/photos';

    $("#recipe_dropzone").dropzone({
        url: endpoint,
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
        init: function()
        {
            if (isNaN(recipeId) === false)
            {
                var dz = this;

                $.ajax({
                    url : APP_URL + 'api/' +  recipeId + '/photos',
                    type: "GET",
                    accept: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .done(function(resp, textStatus)
                {
                    $(resp).each(function(index, photoInfo)
                    {
                        var photo = {
                            size: photoInfo.size,
                            name: photoInfo.filename,
                            url: photoInfo.path,
                            id: photoInfo.id
                        };

                        dz.emit("addedfile", photo);
                        dz.emit("thumbnail", photo, photoInfo.thumbnail_path);
                        dz.emit("complete", photo);
                        dz.files.push(photo);
                    })
                })
                .fail(function(resp, sds)
                {
                    toastr.warning('Error loading recipe photos');
                });


            }
        },
        removedfile: function (file)
        {
            $.ajax({
                url : endpoint,
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
