$(() => {

    let deletedPhotoContainer = $('.deleted-photos');
    
    
    $('.photo-delete').on('click', function(e)
    {
        let delBtn = $(this);
        let photoEl = delBtn.siblings('img');
        let photoId = delBtn.attr('data-photo');

        if (photoId !== undefined && isNaN(photoId) === false)
        {
            if (photoEl !== undefined && photoEl.length > 0)
            {
                photoEl.toggleClass('del');

                if (photoEl.hasClass('deleted'))
                {
                    // Remove the deleted photo ID ref from container
                    let photoIdRef = deletedPhotoContainer.find('#photo-deleted-'+photoId);
                    
                    if (photoIdRef !== undefined && photoIdRef.length > 0) {
                        photoIdRef.remove();
                    }
                    
                    photoEl.removeClass('deleted');

                    // Add `Delete` button text
                    $(this).text('Delete');
                }
                else {
                    photoEl.addClass('deleted');
                    
                    // Add the deleted photo ID ref from the container
                    deletedPhotoContainer.append('<input id="photo-deleted-'+photoId+'" type="hidden" name="delete_photos[]" value="'+photoId+'" />');

                    // Add `Undo delete` button text
                    $(this).text('Undo delete');
                }
            }
        }
        
        e.preventDefault();
    });
    
});