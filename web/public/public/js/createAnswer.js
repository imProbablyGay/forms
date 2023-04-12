// display form questions
let formUrl = '/form/'+formId;
displayForm();

// check if answer is sent
(function () {
    let item = localStorage.getItem('answer_sent');

    if (!item) return;
    let text;
    if (item === 'uploaded') {
        text = 'Ваш ответ записан!';
    } else {
        text = 'Упс, произошла ошибка';
    }
    localStorage.removeItem('answer_sent');
    showAlertModal(text);
})()

// let user unset selected radio option
questionsNode.addEventListener('click', (e) => {
    // check if radio option
    if (e.target.tagName === 'INPUT' && e.target.type === 'radio' && e.target.dataset.optionId) {
        let node = getEl(e.target, 'question__options');
        // check unset option block
        if (!node.querySelector('.option__unset')) {
            unsetNode = document.createElement('div');
            unsetNode.classList = 'option__unset';
            unsetNode.innerHTML = '<span>Отменить выбор</span>';
            node.append(unsetNode);
        }
    }
    // unset radio option
    else if (e.target.parentElement.classList.contains('option__unset')) {
        questionsNode.querySelector('input:checked').checked = false;
        e.target.parentElement.remove();
    }
})

// upload answer
document.querySelector('.answer__create').addEventListener('click', uploadNewAnswer);

// functions
function uploadNewAnswer() {
    // disable btn to send only one answer
    this.disabled = true;

    // check required questions
    for (let item of document.querySelectorAll('.question__required')) {
        let answered = item.querySelector('input:checked') ?? item.querySelector('textarea');

        if (!answered || !answered.value) {
            item.scrollIntoView({behavior: "smooth"})
            item.classList.add('question__not-set');
            return false;
        }
        item.classList.remove('question__not-set');
    }

    // get questions data
    let questions = [];
    for (let item of document.querySelectorAll('.question')) {
        // get options data
        let options = [];
        let option = {};

        for (let optionItem of item.querySelectorAll('[data-option-type]')) {
            let optionValue = null;
            if (optionItem.dataset.optionType === 'choose' && optionItem.checked) {
                // get another option value
                if (optionItem.dataset.anotherOption) optionValue = optionItem.parentElement.parentElement.querySelector('.option__another-input').value;
            }
            else if (optionItem.dataset.optionType === 'text' && optionItem.value) optionValue = optionItem.value;
            // if answer is not answered
            else continue;

            option = {
                'o_id': optionItem.dataset.optionId,
                'value': optionValue
            };
            options.push(option);
        }

        // if answer is not answered, add default values
        if (options.length === 0) {
            options.push({'o_id':null, 'value': null});
        }

        let question = {
            'q_id': item.dataset.questionId,
            'type': item.dataset.questionType,
            'options': options
        };

        questions.push(question);
    }

    postJSON(`/form/${formId}/upload_answer`, {'questions': questions})
    // hide form
    .then((data) => data.json())
    .then(data => {
        let success = 'uploaded';
        if (!data.success) success = 'error';

        localStorage.setItem('answer_sent', success);
        location.reload()
    })
}

function handleChooseOption(optionsArray,type) {
    let output = '';

    optionsArray.forEach(option => {
        let optionContent = `<span class='option__text'>${option['value']}</span>`;
        let isAnotherOption = '';

        // check another
        if (option['another']) {
            optionContent = `<h6 class='option__another-text'>Другое: </h6><input type='text' maxlength='1000' data-another-option='true' class='option__another-input'>`
            isAnotherOption = `data-another-option=true`;
        }

        output += `
            <div class="question__option option">
                <label class="${type}">
                    <input type="${type}" name='${option['q_id']}' ${isAnotherOption} data-option-type='choose' data-option-id='${option['id']}'>
                    <span class="checkmark"></span>
                </label>
                ${optionContent}
            </div>`;
    })

    return output;
}

function handleTextOption(options) {
    return  `
        <div class="question__option option">
            <textarea data-option-type='text' data-option-id=${options[0].id} maxlength='1000' placeholder='Ваш ответ...'></textarea>
        </div>`;
}

