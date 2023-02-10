let imgSpot = document.querySelector('.change-icon');
let uploadInp = document.querySelector('.upload-inp');

// modal
let uploadIconModal = document.getElementById('upload_icon_modal');
let text = uploadIconModal.querySelector('.modal-body').innerHTML
// clear content on close
uploadIconModal.addEventListener('hidden.bs.modal', function() {
    this.querySelector('#acceptNewIcon').classList.add('d-none');
    uploadIconModal.querySelector('.modal-body').innerHTML = text;
    document.querySelector('.upload-inp').addEventListener('change', editImage);
});


uploadInp.addEventListener('change', editImage);

function editImage(e) {
    // hide upload inpup
    imgSpot.querySelector('.change-icon__btn').classList.add('d-none');
    let reader = new FileReader()
    let file = e.target.files[0];
    reader.readAsDataURL(file)
    reader.onloadend = () => {
        let imgBASE64 = reader.result;
        imgSpot.innerHTML += '<div class="choose-img"><img src='+imgBASE64+' id="image" height="auto" width="100%"></div>';
        acceptNewIcon.classList.remove('d-none'); //add apply button
        var image = document.querySelector('#image');
        var minAspectRatio = 1;
        var maxAspectRatio = 1;
        let cropper = new Cropper(image, {
            viewMode: 1,
            ready: function () {
            let cropper = this.cropper;
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
            }
        });
        acceptNewIcon.addEventListener('click', ()=>uploadNewIcon(cropper));

        reader = null;
        file = null;
    };
}

function uploadNewIcon(cropper) {
    let newIcon = cropper.getCroppedCanvas().toDataURL('image/jpeg').split(',')[1];
    postJSON('/profile/update_picture', {'image': newIcon})
    .then(() => {
        location.reload()
    })
}
