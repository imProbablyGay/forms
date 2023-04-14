let TABS_VALUES = {
    'statistics_offset': 0,
    'certain_answer_offset': 0
};

// url where ajax send request
let formUrl;

// handle switch between questions and answers
let profileControls = document.querySelector('.profile-form .controls');
let profileTabs = document.querySelectorAll('[data-form-tab]');
let profileTabsQuestions = document.querySelectorAll('[data-form-tab-questions]');

// display form on default
(function() {
    let answerId = getQueryArg('answer'); //answer id in query string

    // display statistics tab
    if (!answerId) {
        // set tabs statistics offset
        TABS_VALUES.statistics_offset = QUESTION.limit;
        displayStatisticsTab()
    }
    // display certain answer tab
    else {
        // set tabs certain answer offset
        TABS_VALUES.certain_answer_offset = QUESTION.limit;
        displayCertainAnswerTab()
        switchTabs('certain_answer');
    }
})()


document.addEventListener('scroll', loadMoreTextValues, true /*Capture event*/);

// copy form link on click
document.querySelector('.profile-form__copy-link').addEventListener('click', function() {
    navigator.clipboard.writeText(this.dataset.copyLink);
    showAlertModal('<b>Ссылка скопирована</b><br>Пришлите эту ссылку человеку, который должен ответить на эту форму');
})

// tabs controls
profileControls.addEventListener('click', (e) => {
    if (!e.target.classList.contains('controls__item')) return;

    let action = e.target.dataset.formAction;

    // load and switch to answers
    if (action === 'certain_answer') {
        if (document.querySelector('.profile-form__certain-answer .questions').children.length === 0) {
            QUESTION.offset = 0;

            displayCertainAnswerTab();
            // set tabs statistics offset
            TABS_VALUES.certain_answer_offset = QUESTION.limit;
        }

        switchTabs('certain_answer');
    }
    // load and switch to statistics
    else if (action === 'statistics') {
        if (document.querySelector('.profile-form__statistics .questions').children.length === 0) {
            QUESTION.offset = 0;

            displayStatisticsTab();

            // set tabs statistics offset
            TABS_VALUES.statistics_offset = QUESTION.limit;
        }

        switchTabs('statistics');
    }
});

// change certain answer
try {
    document.querySelector('.certain-answer__controls input').addEventListener('change', changeCertainAnswer);
}catch(e) {}
// remove default function of loading more questions
document.removeEventListener('scroll', loadQuestions);
// add custom function of loading more questions
document.addEventListener('scroll', customLoadQuestions);

// return back to profile
document.querySelector('.profile__back-btn').addEventListener('click', () => location.href='/profile');

// functions

// display statistics tab on load
async function displayStatisticsTab() {
    formUrl = '/profile/form/'+formId+'/statistics';
    displayForm({'extended_questions_node': '.statistics__questions', 'type': 'statistics'});
}

async function displayCertainAnswerTab() {
    let answerInput = document.querySelector('.certain-answer__controls input');
    // change form url
    if (getQueryArg('answer')) answerInput.value = getQueryArg('answer');
    // get answer id from input
    let answerId = document.querySelector('.certain-answer__controls input').value;

    formUrl = '/profile/form/'+formId+'/certain_answer/'+answerId;//default answer id is 1
    // display and check if exists
    displayForm({'extended_questions_node': '.certain-answer__questions', 'type': 'certain_answer'});
}

function switchTabs(action) {
    // switch btn
    profileControls.querySelectorAll('.controls__item').forEach(el => el.classList.remove('active'));
    profileControls.querySelector(`[data-form-action="${action}"]`).classList.add('active');

    // switch tabs
    Array.from(profileTabs).forEach(el => el.classList.add('d-none'));
    document.querySelector(`[data-form-tab="${action}"]`).classList.remove('d-none');
}

// clean and change certain answer
function changeCertainAnswer() {
    // clear existing questions
    document.querySelector('.certain-answer__questions').innerHTML = '';

    // add event if it is removed
    document.addEventListener('scroll', customLoadQuestions);

    // clear existing form
    TABS_VALUES.certain_answer_offset = 0;
    QUESTION.offset = 0;
    customLoadQuestions()
}

// custom function of loading more questions
async function customLoadQuestions() {
    // check offset
    let activeTab = document.querySelector('.controls .active').dataset.formAction;
    let questionNode = document.querySelector(`[data-form-tab="${activeTab}"]`);
    if (questionNode.getBoundingClientRect().bottom - globalThis.innerHeight > 200) return;

    // remove event to request only one time
    document.removeEventListener('scroll', customLoadQuestions);

    // if statistics tab
    let form;
    if (activeTab === 'statistics') {
        QUESTION.offset = TABS_VALUES.statistics_offset;

        formUrl = '/profile/form/'+formId+'/statistics';
        form = await getForm();

        // increase offset
        TABS_VALUES.statistics_offset += QUESTION.limit;
    }
    // if certain answer tab
    else if (activeTab === 'certain_answer') {
        // get current answer id
        let answerId = document.querySelector('.certain-answer__controls input').value;

        QUESTION.offset = TABS_VALUES.certain_answer_offset;

        formUrl = '/profile/form/'+formId+'/certain_answer/'+answerId;
        form = await getForm();

        // set date of publication
        setPublicationDate(form.date);

        // increase offset
        TABS_VALUES.certain_answer_offset += QUESTION.limit;
    }
    // append html
    let questions = getQuestionsHtml(form.questions);
    questionNode.querySelector(`.questions`).append(questions);

    // add event
    document.addEventListener('scroll', customLoadQuestions);
}

// get text values of answers
async function loadMoreTextValues(e) {
    try {
        if (!e.target.classList.contains('option__scroll'));
        if (e.target.scrollTop + e.target.offsetHeight < e.target.scrollHeight - 70) return;
        document.removeEventListener('scroll', loadMoreTextValues, true /*Capture event*/);


        let parentNode = e.target;
        let o_id = e.target.dataset.optionId;
        let offset = e.target.querySelectorAll('.option__scroll-item').length;
        let values = await postJSON('/profile/option/'+o_id, {'offset': offset});
        values = await values.json();

        // check if all text values are displayed
        if (values.length === 0) {
            document.addEventListener('scroll', loadMoreTextValues, true /*Capture event*/);
            return;
        }

        // form received text values
        let output = document.createElement('div');
        let valuesNode = '';
        values.forEach(el => {
            valuesNode += `<div class='option__scroll-item'><span>${el.text}</span></div>`
        })

        output.innerHTML = valuesNode;
        parentNode.append(output);

        document.addEventListener('scroll', loadMoreTextValues, true /*Capture event*/);
    } catch(e) {}
}

function handleChooseOption(optionsArray,type) {
    let output = '';
    let activeTab = document.querySelector('.controls .active').dataset.formAction;

    // if statistics tab
    if (activeTab === 'statistics') {
        optionsArray.forEach(option => {
            let optionContent = `<span class='option__text'>${option.value}</span>`;

            // check another
            if (option['another']) {
                // add scroll menu with answers
                optionContent = `<h6 class='option__another-text'>Другое: </h6>`;

                // insert values if they exist
                if (option.text.length > 0) {
                    optionContent += `<div class='option__scroll' data-option-id='${option.id}'>`;
                    option.text.forEach(value => {
                        optionContent += `<div class='option__scroll-item'><span>${value.text}</span></div>`;
                    });
                    optionContent += '</div>';
                }
                else {
                    optionContent += `<input type='text' disabled class='option__another-input' placeholder='Текстовое поле...'>`;
                }

            }

            // display statistics if it is not zero
            let statisticsNode = '';
            let percentage = (option.amount/option.total*100).toFixed(2);
            if (!isNaN(percentage)) statisticsNode = `<div class='option__statistics'><span>(${option.amount} из ${option.total}/${percentage}%)</span></div>`;


            output += `
            <div class="question__option option flex-column">
                ${statisticsNode}
                <div class='d-flex flex-wrap'>
                <label class="${type}">
                    <input type="${type}" disabled checked>
                    <span class="checkmark"></span>
                </label>
                ${optionContent}
                </div>
            </div>`;
        })
    }
    // if certain answer tab
    else if (activeTab === 'certain_answer') {
        // TODO option in certain answer
        optionsArray.forEach(option => {
            let optionContent = `<span class='option__text'>${option.value}</span>`;
            let checked = '';

            // check if option is choosen
            if (option.data.choosed === true) checked = 'checked';

            // check another
            if (option['another']) {
                // add scroll menu with answers
                optionContent = `<h6 class='option__another-text'>Другое: </h6>`;

                // insert values if they exist
                if (checked === 'checked') {
                    optionContent += `
                    <div class='option__scroll' data-option-id='${option.id}'>
                        <div class='option__scroll-item'><span>${option.data.text}</span></div>
                    </div>`;
                }
                else {
                    optionContent += `<input type='text' disabled class='option__another-input' placeholder='Текстовое поле...'>`;
                }

            }

            output += `
            <div class="question__option option flex-column">
                <div class='d-flex flex-wrap'>
                <label class="${type}">
                    <input type="${type}" disabled ${checked}>
                    <span class="checkmark"></span>
                </label>
                ${optionContent}
                </div>
            </div>`;
        })
    }

    return output;
}

function handleTextOption(options) {
    // get text values
    let output = '';
    let activeTab = document.querySelector('.controls .active').dataset.formAction;

    // if statistics tab
    if (activeTab === 'statistics') {
        if (options[0].text.length > 0) {
            output = '<div class="option__scroll-title"><span>Ответы:</span></div>';
            output += `<div class="option__scroll" data-option-id='${options[0].id}'>`;
            options[0].text.forEach(value => {
                output += `<div class='option__scroll-item'><span>${value.text}</span></div>`;
            });
            output += '</div>';
        }
        else {
            output += `<textarea placeholder='Текстовое поле...' disabled></textarea>`;
        }
    }
    // if certain answer tab
    else if (activeTab === 'certain_answer') {
        // TODO text option in certain answer
        if (options[0].data.text) {
            output = `
            <div class="option__scroll-title"><span>Ответы:</span></div>
            <div class="option__scroll">
                <div class='option__scroll-item'><span>${options[0].data.text}</span></div>
            </div>`
        }
        else {
            output += `<textarea placeholder='Текстовое поле...' disabled></textarea>`;
        }
    }

    return `
    <div class="question__option option d-flex flex-wrap">
        ${output}
    </div>`;
}

