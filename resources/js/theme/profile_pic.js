$(function(){

    const image = document.getElementById('profile_pic');
    
    var URL = window.URL || window.webkitURL;
    
    var options = {
        aspectRatio: 4 / 3,
        viewMode: 3,
        autoCrop: false,
        zoomable: false,
        zoomOnWheel: false,
        rotatable: false,
        movable: false,
        scalable: false,
        minCropBoxWidth: 150,
        minCropBoxHeight: 150
    };
    
    // minContainerHeight
    // minCanvasWidth
    
    var cropper = new Cropper(image, options);
    var uploadedImageURL;

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Buttons
    if (!document.createElement('canvas').getContext) {
        $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
    }

    if (typeof document.createElement('cropper').style.transition === 'undefined') {
        $('button[data-method="rotate"]').prop('disabled', true);
        $('button[data-method="scale"]').prop('disabled', true);
    }

    $('form#profile-details-form').on('submit', function(event)
    {
        var cropData = cropper.getData(true);
       
        $('#img-x').val(cropData.x);
        $('#img-y').val(cropData.y);
        $('#img-w').val(cropData.width);
        $('#img-h').val(cropData.height);
    });

    // Import image
    var inputImage = document.getElementById('pic_file');

    if (URL) {
        inputImage.onchange = function () {
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
                    cropper.clear();
                    
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        };
    } else {
        inputImage.disabled = true;
        inputImage.parentNode.className += ' disabled';
    }
    
});