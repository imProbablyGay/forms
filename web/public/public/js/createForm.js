// fix non editing input in tinymce
document.addEventListener('focusin', function (e) {
    if (e.target.closest('.tox-tinymce-aux, .moxman-window, .tam-assetmanager-root') !== null) {
      e.stopImmediatePropagation();
    }
  });


let uploadFormModal = document.getElementById('upload_new_form_modal');
let upload_new_form_modal = new bootstrap.Modal(uploadFormModal);
let countText = document.querySelector('.count__text >span');


displayTextCount();//display text count on load
showUploadFormModal()


function showUploadFormModal(formId = null) {
    upload_new_form_modal.show();
    initUploadFormModal();

    // create new question
    let controls = uploadFormModal.querySelector('.form__options').children;
    if (formId === null) {
        controls[0].classList.add('active');
    }

}



function initUploadFormModal(id = 'uploadForm') {
    const image_upload_handler_callback = (blobInfo) => new Promise((resolve) => {
        let blob = blobInfo.blob();
        let formData = new FormData();
        formData.append('file', blob);
        fetch('/form/create_process', {
            method: "POST",
                headers: {
                    'X-CSRF-TOKEN': getToken()
                },
                body: formData
        })
        .then(data => data.json())
        .then(data => {
            resolve(data.location)

            //hide modal
            document.querySelector('.tox-dialog__footer-end').children[1].click();
            let content = tinymce.activeEditor.getContent() + `<img src='${data.location}'>`;
            tinymce.activeEditor.setContent(content);
            tinymce.activeEditor.selection.select(tinyMCE.activeEditor.getBody(), true);
            tinymce.activeEditor.selection.collapse(false);
            tinymce.activeEditor.focus();
        })
        .catch(e => console.log(e))
    });
    tinymce.init({
        selector: '#'+id,
        plugins: 'codesample image wordcount visualchars',
        toolbar: "bold italic underline | codesample | image",
        image_dimensions: false,
        images_upload_url: '/form/create_process',
        content_style: 'img {max-width: 100%;max-height:500px;}',
        language:'ru',
        menubar:false,
        image_description: false,
        object_resizing : false,
        statusbar: false,
        setup: function(editor) {
            editor.on('keydown', function(e) {
                    let lengthAfter = editor.plugins.wordcount.body.getCharacterCount();
                    displayTextCount(lengthAfter, e, editor);
            });
        },
        images_upload_handler: image_upload_handler_callback
    });
}

//text count 33
function displayTextCount(lengthAfter = null, e = null, editor = null) {
    const limit = 10;
    const keysToExclude = ['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'Backspace'];

    if (lengthAfter === null) { //if page loaded
        countText.innerHTML = `0/${limit}`;
    }
    else if (lengthAfter >= limit) { // if increases limit
        if (!keysToExclude.includes(e.key)){
            e.preventDefault()
        }
        else {
            setTimeout(() => {
                countText.innerHTML = editor.plugins.wordcount.body.getCharacterCount() + '/' + limit;
            }, 0);
        }
    }
    else { // default
        setTimeout(() => {
            countText.innerHTML = editor.plugins.wordcount.body.getCharacterCount() + '/' + limit;
        }, 0);
    };
}





