// this file consists of functions, which display published form

const QUESTION = {
    // default question node
    'node': function () {
        let shell = document.createElement('div');
        shell.classList.add('question');

        shell.innerHTML =`
            <div class="question__text"></div>
            <div class="question__options" data-question-type=''></div>`;

        return shell;
    },
    'offset': 0,
    'limit': Math.round(globalThis.innerHeight / 100)
};

let formId = location.pathname.split('/').pop();
let questionsNode = document.querySelector('.questions');


// load more questions
document.addEventListener('scroll', loadQuestions)


async function displayForm(data = null) {
    // get form via ajax
    let form = await getForm();

    // check if error
    if (form.error) return false;

    // display html
    let formNode = document.querySelector('.form');
    // insert title in all tabs
    Array.from(formNode.querySelectorAll('.form__title h2')).forEach(el => el.innerHTML = form.title);

    // add date of creating answer if certain answer tab
    if (data && data.type === 'certain_answer') {
        setPublicationDate(form.date);
    }

    // insert questions
    // extended_questions_node - arg which contains addidional classname of output node
    let additionNode = '';
    if (data && data.extended_questions_node) {
        additionNode = data.extended_questions_node;
    }

    // get questions
    let questionsHTML = getQuestionsHtml(form.questions);
    let questinonsNode = formNode.querySelector(`${additionNode}.questions`);
    questinonsNode.prepend(questionsHTML);

    // replace user icon
    replaceProfilePicture();
}

async function loadQuestions() {
    if (questionsNode.getBoundingClientRect().bottom - globalThis.innerHeight > 200) return;

    // remove event to request only one time
    document.removeEventListener('scroll', loadQuestions);

    let form = await getForm();
    // check empty
    if (form.questions.length === 0) {
        return false;
    }

    // append html
    let questions = getQuestionsHtml(form.questions);
    document.querySelector('.questions').append(questions);

    // add event
    document.addEventListener('scroll', loadQuestions);
}

function getQuestionsHtml(questions) {
    // object with functions which render options
    let handleOptions = {
        'radio': (options) => handleChooseOption(options,'radio'),
        'checkbox': (options) => handleChooseOption(options,'checkbox'),
        'text': (options) => handleTextOption(options),
    };

    let questionsHtmlPlace = document.createElement('div');
    Object.values(questions).forEach(question => {
        let questionNode = QUESTION.node().cloneNode(true);

        // add extension function
        if (question.answers_amount) questionNode.prepend( totalAnswersAmountFn(question.answers_amount));

        // set data attributes
        questionNode.dataset.questionId = question['id'];
        questionNode.dataset.questionType = question['type'];

        // question title
        let content = question['text'];
        if (question['is_required']) {
            content = '<span style="color:red;">* это обязательный вопрос</span>&nbsp' + content; //if required
            questionNode.classList.add('question__required');
        }
        questionNode.querySelector('.question__text').innerHTML = content;

        // question type
        questionNode.querySelector('.question__options').dataset.questionType = question['type'];

        // insert options
        let demandedData = question['options'];
        if (demandedData.length === 0) demandedData = question['id'];

        let options = handleOptions[question['type']](demandedData);
        questionNode.querySelector('.question__options').innerHTML = options;
        questionsHtmlPlace.append(questionNode);
    })


    return questionsHtmlPlace;
}

async function getForm() {
    // get form
    let form = await postJSON(formUrl, {'q_limit': QUESTION.limit, 'offset': QUESTION.offset});
    form = await form.json();
    // increase offset
    QUESTION.offset += QUESTION.limit;

    return form;
}

function totalAnswersAmountFn(amount) {
    let totalAmount = document.createElement('div');
    totalAmount.classList.add('profile-form-question__total-amount');
    totalAmount.innerHTML = `<span>Ответов на этот вопрос: ${amount}</span>`;

    return totalAmount;
}

function setPublicationDate(date) {
    document.querySelector('.certain-answer__date b').innerHTML = 'Добавлен: ' + date;
}
