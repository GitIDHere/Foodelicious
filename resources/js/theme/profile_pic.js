$(function()
{
    /**
     * Look at this issue if you want to set the width and height of the container
     * https://github.com/fengyuanchen/cropper/issues/833
     */

    const image = document.getElementById('profile_pic');
    var URL = window.URL || window.webkitURL;
    var cropper = null;
    var uploadedImageURL;
    var profilePic = $('img#profile_pic');
    var picContainer = $('#profile_pic_container');
    // Import image
    var picInputEl = document.getElementById('pic_file');

    var options = {
        aspectRatio: 4 / 3,
        viewMode: 1,
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

    if (URL)
    {
        if (picInputEl !== undefined && picInputEl !== null)
        {
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

                        picContainer.css({
                            "max-width": "500px",
                            "min-width": "200px",
                            "min-height": "500px",
                        });

                        cropper = new Cropper(image, options);
                        //profilePic.removeClass('default-pic');

                    } else {
                        window.alert('Please choose an image file.');
                    }
                }
            };
        }
    } else {
        picInputEl.disabled = true;
        picInputEl.parentNode.className += ' disabled';
    }

});
