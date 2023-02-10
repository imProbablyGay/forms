// fix non editing input in tinymce
document.addEventListener('focusin', function (e) {
    if (e.target.closest('.tox-tinymce-aux, .moxman-window, .tam-assetmanager-root') !== null) {
      e.stopImmediatePropagation();
    }
  });

// variables
const QUESTION = {
    'el':document.querySelector('.question'),
    'text_option': `<div class="question__option option">
        <textarea class="question__input-text" maxlength="1000" placeholder="Введите значение"></textarea>
    </div>`,
    'choose_option': function () {return QUESTION.el.querySelector('.option').outerHTML}
};
QUESTION.el.remove();

let uploadQuestionModal = document.getElementById('upload_new_question_modal');
let upload_new_question_modal = new bootstrap.Modal(uploadQuestionModal);
let countText = document.querySelector('.count__text >span');
let questionCreate = document.querySelector('.new-question__show');
let questionOptions = document.querySelector('.new-question__type');
const limit = 10;// modal text limit


// events
uploadQuestionModal.addEventListener('hidden.bs.modal', clearQuestionModal);
document.querySelector('.new-question__textarea').addEventListener('click', hideNewQuestionOptions)

// show modal
document.querySelector('.new-question__add').addEventListener('click', () => upload_new_question_modal.show());

// show edit modal
document.querySelector('.questions__spot').addEventListener('click', showEditModal);

// display new question
questionCreate.addEventListener('click', function (e) {
    let data = {
        'text': tinymce.activeEditor.getContent(),
        'type': questionOptions.querySelector('.dropdown-toggle').children[0].dataset.type
    };

    // clear modal
    clearQuestionModal();

    // hide modal
    upload_new_question_modal.hide()

    // handle edit question action
    if (this.classList.contains('edit')) {
        this.classList.remove('edit');

        return handleEditQuestion(data);
    }

    createQuestion(data);
})

// add more options
document.addEventListener('click', (e) => {
    let el = getParentEl(e.target, 'option__add',1);
    if (!el) return;

    let type = el.dataset.optionType;
    let outputBlock = getEl(e.target, 'question__options');
    let output = outputBlock.children[0].cloneNode(true);
    output.querySelector('input[type="text"]').value = '';

    if (type === 'another') {
        el.classList.add('d-none');
        output.querySelector('input[type="text"]').disabled = true;
        output.querySelector('input[type="text"]').placeholder = 'Другое...'
        output.querySelector('input[type="text"]').classList.add('option__input-another');
    }

    try {
        outputBlock.insertBefore(output, outputBlock.querySelector('.option__input-another').parentNode);
    } catch(e) {
        outputBlock.append(output);
    }
    output.querySelector('input[type="text"]').focus()
})

//remove question options
document.querySelector('.questions__spot').addEventListener('click', (e) => {
    if (getParentEl(e.target, 'option__delete', 1)) {
        let option = getEl(e.target,'question__option');

        // check required amount of options
        if (getEl(option, 'question__options').children.length === 2) return;

        // restore another option
        if (option.querySelector('.option__input-another')) {
            console.log(3);
            getEl(option, 'question').querySelector('.option__add-another').classList.remove('d-none');
        }

        option.remove();
    }
})

// remove question
document.querySelector('.questions__spot').addEventListener('click', (e) => {
    if (!getParentEl(e.target, 'question__delete', 1)) return;

    getEl(e.target, 'question').remove();
})

//choose new question type
document.querySelectorAll('.new-question .dropdown-menu .dropdown-item').forEach(el => {
    el.addEventListener('click', (e) => {
        let item = el.children[0].cloneNode(true);
        let togglerParent = getEl(el, 'dropdown-toggle');
        togglerParent.replaceChild(item, togglerParent.children[0]);
        document.querySelector('.dropdown-menu .d-none').classList.remove('d-none');
        el.classList.add('d-none');
    })
})

//hide question options if textarea is clicked
document.querySelector('.new-question__textarea').addEventListener('click', () => {
    let el = document.querySelector('.new-question__type');
    try {
        el.querySelectorAll('.show').forEach(el => el.classList.remove('show'));
    } catch(e) {}
})

// upload form
document.querySelector('.form__create').addEventListener('click', () => {
    let questions = [];

    for (let question of document.querySelectorAll('.question')) {
        let options = [];
        let error = false;

        question.querySelectorAll('.option__input').forEach(el => {
            // add "another" option
            if (el.classList.contains('option__input-another')) {
                options.push({"another_option": true})
                return;
            }
            // if empty value input
            else if (el.value.trim() === '') {
                el.scrollIntoView({behavior: "smooth"})
                el.focus();
                error = true;
                questions = [];
                return false;
            }
            options.push(el.value);
        });

        // if any input is empty
        if (error) break;

        let questionData = {
            "title": question.querySelector('.question__text').innerHTML,
            "type": question.querySelector('.question__options').dataset.questionType,
            "options": options,
            "required": question.querySelector('.question__requirable input').checked
        };

        questions.push(questionData);
    }

    if (questions.length > 0) {
        let form = {
            'name': 'title 123',
            'questions': questions
        };
        postJSON('/form/create', {'form': form})
        .then(data => data.text())
        .then(data => console.log(data))
    }
})


//functions usage
displayTextCount();// display 0/10 onload
initUploadQuestionModal(); //init tinyMCE

// question create HTML
createQuestion({'text': 'sdf', 'type': 'radio'})

//functions declaration

// try to hide new question type options
function hideNewQuestionOptions (){
    let el = document.querySelector('.new-question__type');
    try {
        el.querySelectorAll('.show').forEach(el => el.classList.remove('show'));
    } catch(e) {}
}

// edit question
function handleEditQuestion(data) {
    let question = document.querySelector('[data-edit-question="true"]');
    question.removeAttribute('data-edit-question');

    // set title
    question.querySelector('.question__text').innerHTML = data.text;

    // set options
    let currentType = question.querySelector('[data-question-type]').dataset.questionType;
    let optionsNode = question.querySelector('.question__options');

    optionsNode.dataset.questionType = data.type; // change options type

    if (currentType === 'radio'|| currentType === 'checkbox') {
        // change from radio to checkbox and conversly
        if (data.type === 'radio' || data.type === 'checkbox') {
            setOptionType();
        }
        // change from radio/checkbox to text
        else if (data.type === 'text') {
            optionsNode.innerHTML = QUESTION.text_option;

            // hide add more options block
            question.querySelector('.options__add').classList.add('d-none');
        }
    }
    else if (currentType === 'text') {
        if (data.type === 'radio' || data.type === 'checkbox') {
            optionsNode.innerHTML = QUESTION.choose_option() + QUESTION.choose_option();
            setOptionType();
        }
    }

    function setOptionType() {
        optionsNode.querySelectorAll('label').forEach(el => {
            el.classList = '';
            el.classList.add(data.type);
            el.children[0].type = data.type;
        })

        // show add more options block
        question.querySelector('.options__add').classList.remove('d-none');
        question.querySelector('.option__add-another').classList.remove('d-none');
    }
}

// question modal
function showEditModal(e) {
    if (!e.target.classList.contains('question__edit')) return;

    // mark question
    getEl(e.target, 'question').dataset.editQuestion = true;

    let text = getEl(e.target,'question__text');
    let type = getEl(e.target,'question__options').dataset.questionType;

    // set content
    tinymce.activeEditor.setContent(text.innerHTML);
    displayTextCount(text.textContent.length);

    // set type
    uploadQuestionModal.querySelector(`.dropdown-menu [data-type="${type}"]`).parentNode.click();

    // change accept btn
    questionCreate.classList.add('edit');

    // change modal title
    uploadQuestionModal.querySelector('.modal-title').textContent = 'Изменить вопрос';

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
        fetch('/form/create_image', {
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
    });
    tinymce.init({
        selector: '#uploadQuestion',
        plugins: 'image wordcount visualchars',
        toolbar: "bold italic underline | image",
        image_dimensions: false,
        images_upload_url: '/form/create_process',
        content_style: 'img {max-width: 100%;max-height:500px;}',
        language:'ru',
        menubar:false,
        image_description: false,
        object_resizing : false,
        statusbar: false,
        placeholder: 'Название вопроса...',
        paste_data_images: false,
        paste_preprocess: (editor, args) => {
            let content = args.content;
            args.content = '';
            setTimeout(() => {
                let el = document.createElement('span');
                el.innerHTML = content;
                let charactersLeft = Math.abs(limit - editor.plugins.wordcount.body.getCharacterCount());
                content = tinymce.activeEditor.getContent() + `<p>${el.textContent.substr(0,charactersLeft)}</p>`;
                tinymce.activeEditor.setContent(content);
                countText.innerHTML = editor.plugins.wordcount.body.getCharacterCount() + '/' + limit;
            }, 0);
          },
        setup: function(editor) {
            editor.on('keydown', function(e) {
                    let lengthAfter = editor.plugins.wordcount.body.getCharacterCount();
                    displayTextCount(lengthAfter, e);
            });
            editor.on('click',  function(e) {
                hideNewQuestionOptions()
            });
        },
        images_upload_handler: image_upload_handler_callback
    });
}
function displayTextCount(lengthAfter = null, e = null) {
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
                countText.innerHTML = tinymce.activeEditor.plugins.wordcount.body.getCharacterCount() + '/' + limit;
            }, 0);
        }
    }
    else { // default
        setTimeout(() => {
            let currentLength = tinymce.activeEditor.plugins.wordcount.body.getCharacterCount();

            if (currentLength == 0) questionCreate.classList.add('d-none');
            else questionCreate.classList.remove('d-none');

            countText.innerHTML = currentLength + '/' + limit;
        }, 0);
    };
}
function clearQuestionModal() {
    // set defaulttitle
    uploadQuestionModal.querySelector('.modal-title').textContent = 'Новый вопрос';

    // set default radio type
    document.querySelector('.new-question__type .dropdown-menu [data-type="radio"]').click()

    displayTextCount();
    tinymce.activeEditor.setContent('');
    tinymce.get('uploadQuestion').remove();
    initUploadQuestionModal()
    questionCreate.classList.add('d-none');
}

function createQuestion(data) {
    let questionNode = QUESTION.el.cloneNode(true);
    questionNode.querySelector('.question__text').innerHTML = data.text;

    let options = questionNode.querySelector('.question__options');
    options.dataset.questionType = data.type;

    // handle options
    if (data.type === 'checkbox' || data.type === 'radio') {
        options.querySelectorAll('label').forEach(el => {
            el.classList.add(data.type);
            el.children[0].type = data.type;
        })
    }
    else if (data.type === 'text') {
        questionNode.querySelector('.options__add').classList.add('d-none');
        options.innerHTML = QUESTION.text_option;
    }

    document.querySelector('.questions__spot').append(questionNode);
}







