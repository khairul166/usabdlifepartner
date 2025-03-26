jQuery(document).ready(function ($) {
    var cropper;
    var image = document.getElementById('imagePreview');

    // When user selects an image
    $('#profilePictureUpload').change(function (event) {
        var files = event.target.files;

        if (files && files.length > 0) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreviewContainer').show(); // Show preview area
                image.src = e.target.result;

                // Destroy previous Cropper instance if exists
                if (cropper) {
                    cropper.destroy();
                }

                // Initialize Cropper.js with square aspect ratio
                cropper = new Cropper(image, {
                    aspectRatio: 1, // Square ratio
                    viewMode: 1,
                    autoCropArea: 1
                });
            };
            reader.readAsDataURL(files[0]);
        }
    });

    // Crop & Upload Button Click
    $('#cropImageBtn').click(function () {
        if (cropper) {
            var canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300
            });

            if (!canvas) {
                alert("Error: Could not create cropped image.");
                return;
            }

            var croppedImage = canvas.toDataURL('image/jpeg'); // Convert canvas to base64 image
            $('#croppedImageData').val(croppedImage);

            if (croppedImage.length < 100) {
                alert("Error: Cropped image is empty.");
                return;
            }

            // Prepare AJAX request
            var formData = new FormData();
            formData.append('cropped_image', croppedImage);
            formData.append('action', 'upload_cropped_profile_picture');

            // ✅ FIX: Use AJAX URL from WordPress
            $.ajax({
                url: ajaxurl, // ✅ Correct AJAX URL
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        // alert('Profile picture updated successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function () {
                    alert('Error uploading image.');
                }
            });
        }
    });
    $('.delete-photo-btn').click(function () {
        var photoId = $(this).data('photo-id');
        var galleryItem = $(this).closest('.gallery-item');

        // Show confirmation popup
        if (confirm("Are you sure you want to delete this photo?")) {
            $.ajax({
                type: "POST",
                url: ajaxurl, // WordPress AJAX URL
                data: {
                    action: "delete_user_photo",
                    photo_id: photoId
                },
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        alert("Photo deleted successfully!");
                        galleryItem.fadeOut(300, function () { $(this).remove(); }); // Remove from UI
                        location.reload();
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function () {
                    alert("Error deleting photo.");
                }
            });
        }
    });
});
