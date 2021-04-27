$(function(){

    const image = document.getElementById('profile_pic');
    var URL = window.URL || window.webkitURL;
    var cropper = null;
    var uploadedImageURL;
    var profilePic = $('img#profile_pic');
    // Import image
    var picInputEl = document.getElementById('pic_file');

    var options = {
        aspectRatio: 4 / 3,
        viewMode: 3,
        zoomable: false,
        zoomOnWheel: false,
        rotatable: false,
        movable: false,
        scalable: false,
        minCropBoxWidth: 150,
        minCropBoxHeight: 150
    };

    $('form#profile-details-form').on('submit', function(event)
    {
        if (cropper !== null)
        {
            var cropData = cropper.getData(true);

            $('#img-x').val(cropData.x);
            $('#img-y').val(cropData.y);
            $('#img-w').val(cropData.width);
            $('#img-h').val(cropData.height);
        }
    });

    profilePic.on('click', function()
    {
        picInputEl.click();
    });

    if (URL) {
        picInputEl.onchange = function () {
            var files = this.files;
            var file;

            if (files && files.length) {
                file = files[0];

                if (/^image\/\w+/.test(file.type)) {
                    uploadedImageType = file.type;
                    uploadedImageName = file.name;

                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                    }

                    image.classList.remove("hidden");
                    image.src = uploadedImageURL = URL.createObjectURL(file);

                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(image, options);
                    //profilePic.removeClass('default-pic');

                } else {
                    window.alert('Please choose an image file.');
                }
            }
        };
    } else {
        picInputEl.disabled = true;
        picInputEl.parentNode.className += ' disabled';
    }

});
