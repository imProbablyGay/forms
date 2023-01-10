    let imgSpot = document.querySelector('.change-icon');
    let iconModal_i = new bootstrap.Modal(document.getElementById('upload_new_icon_modal'))
    let uploadInp = document.querySelector('.upload-inp');

    uploadInp.addEventListener('change', function (e) {
        // hide upload inpup
        imgSpot.querySelector('.change-icon__btn').remove();
        let reader = new FileReader()
        let file = e.target.files[0];
        reader.readAsDataURL(file)
        reader.onloadend = () => {
            let imgBASE64 = reader.result;
            imgSpot.innerHTML += '<div class="choose-img"><img src='+imgBASE64+' id="image" height="auto" width="100%"></div>';
            document.querySelector('#acceptNewIcon').classList.remove('d-none'); //add apply button
            var image = document.querySelector('#image');
            var minAspectRatio = 1;
            var maxAspectRatio = 1;
            var cropper = new Cropper(image, {
                viewMode: 1,
                ready: function () {
                var cropper = this.cropper;
                var containerData = cropper.getContainerData();
                var cropBoxData = cropper.getCropBoxData();
                var aspectRatio = cropBoxData.width / cropBoxData.height;
                var newCropBoxWidth;

                if (aspectRatio < minAspectRatio || aspectRatio > maxAspectRatio) {
                    newCropBoxWidth = cropBoxData.height * ((minAspectRatio + maxAspectRatio) / 2);

                    cropper.setCropBoxData({
                    left: (containerData.width - newCropBoxWidth) / 2,
                    width: newCropBoxWidth
                    });
                }
                },

                cropmove: function () {
                var cropper = this.cropper;
                var cropBoxData = cropper.getCropBoxData();
                var aspectRatio = cropBoxData.width / cropBoxData.height;

                if (aspectRatio < minAspectRatio) {
                    cropper.setCropBoxData({
                    width: cropBoxData.height * minAspectRatio
                    });
                } else if (aspectRatio > maxAspectRatio) {
                    cropper.setCropBoxData({
                    width: cropBoxData.height * maxAspectRatio
                    });
                }
                },
            });

            acceptNewIcon.addEventListener('click', ()=>uploadNewIcon(cropper));
        }
    });


function uploadNewIcon(cropper) {
    let newIcon = cropper.getCroppedCanvas().toDataURL('image/jpeg').split(',')[1];
    postJSON('/edit_profile_picture_process', {'image': newIcon})
    location.reload()
}
