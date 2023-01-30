// fix non editing input in tinymce
document.addEventListener('focusin', function (e) {
    if (e.target.closest('.tox-tinymce-aux, .moxman-window, .tam-assetmanager-root') !== null) {
      e.stopImmediatePropagation();
    }
  });

// variables
let uploadQuestionModal = document.getElementById('upload_new_question_modal');
let upload_new_question_modal = new bootstrap.Modal(uploadQuestionModal);
let countText = document.querySelector('.count__text >span');
let questionCreate = document.querySelector('.new-question__show');
let questionOptions = document.querySelector('.new-question__options');
let questionsSpot = document.querySelector('.new-questions__spot');


// events
uploadQuestionModal.addEventListener('hidden.bs.modal', clearQuestionModal);

questionOptions.querySelectorAll('.new-question__option').forEach(el => {
    el.addEventListener('click', function () {
        questionOptions.querySelector('.active').classList.remove('active')
        el.classList.add('active');
    })
})

document.querySelector('.new-question__add').addEventListener('click', () => showUploadQuestionModal())

document.querySelector('.new-question__show').addEventListener('click', function (e) {
    let data = {
        'text': tinymce.activeEditor.getContent(),
        'type': questionOptions.querySelector('.active').dataset.type
    };
    // clear modal
    clearQuestionModal();
    createQuestion(data);
})

document.querySelector('.questions').addEventListener('click', (e) => {
    if (!e.target.classList.contains('option__add')) return;
    e.target.children[0].classList.toggle('shown');
})
document.addEventListener('click', (e) => {
    if (!e.target.classList.contains('option__add')) {
        try {
            document.querySelector('.option__add-options.shown').classList.remove('shown');
        } catch(e) {}
    }
});
// document.querySelector('.question__change').addEventListener('click', (e) => {showUploadQuestionModal(id)});



//functions usage
displayTextCount();// display 0/10 onload

//functions declaration

// question modal
initUploadQuestionModal();
function showUploadQuestionModal(questionId = null) {
    upload_new_question_modal.show();
}
function initUploadQuestionModal(questionId = null) {
    // create new question
    if (questionId === null) {
        questionOptions.children[0].classList.add('active');
    }
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
        selector: '#uploadQuestion',
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
            let currentLength = editor.plugins.wordcount.body.getCharacterCount();

            if (currentLength == 0) questionCreate.classList.add('d-none');
            else questionCreate.classList.remove('d-none');

            countText.innerHTML = currentLength + '/' + limit;
        }, 0);
    };
}
function clearQuestionModal() {
    questionOptions.querySelector('.active').classList.remove('active');
    displayTextCount();
    tinymce.activeEditor.setContent('');
    tinymce.get('uploadQuestion').remove();
    initUploadQuestionModal()
    questionCreate.classList.add('d-none');
}

// question create HTML
function createQuestion(data) {
    let template = `${data.text}`;

    let shell = document.createElement('div');
    shell.classList.add('question', 'col-12');
    shell.innerHTML = template;
    questionsSpot.append(shell);
}







