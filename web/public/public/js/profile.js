// variables
let ANSWERS = {
    'offset': 0,
    'limit': Math.round(globalThis.innerHeight / 80)
};

let answersScrollBlock = document.querySelector('.profile__forms-place');

// events
answersScrollBlock.addEventListener('scroll', loadMoreAnswers);

// show modal to confirm removing form
document.querySelector('.profile__forms-place').addEventListener('click', (e) => {
    if (!e.target.dataset.formId) return;

    showConfirmRejectModal('Вы действительно хотите удалить эту форму?', () => {deleteForm(e.target.dataset.formId, e.target)});
})

// function usage

// display answers or display text message
displayAnswers();


// functions

// delete form fn
function deleteForm(formId, target) {
    // send ajax
    postJSON('/form/delete/'+formId, {})

    // remove from DOM
    let formNode = getEl(target, 'profile__answer');
    formNode.remove();

    // decrease amount of forms
    let amountNode = document.querySelector('.profile__forms-title span');
    let newAmount = amountNode.innerHTML - 1;
    amountNode.innerHTML = newAmount;

    // check if there is no forms left
    if (!document.querySelector('.profile__answer')) {
        displayAnswers(false);
    }
}

async function displayAnswers(answers = true) {
    let answersHTML = await getAnswers();

    // if there is no answers
    if (answersHTML.children.length === 0 || !answers) {
        answersScrollBlock.innerHTML =
        `<div class='no-answers'>
            <span>У вас пока нет ни одной формы</span>
        </div>`;
    }
    // if there are answers to display
    else {
        answersScrollBlock.append(answersHTML);
    }
}

async function getAnswers() {
    return await postJSON('/profile/get_answers_description',{'offset': ANSWERS.offset, 'limit': ANSWERS.limit})
    .then(data => data.json())
    .then(data => {
        // increase answers offset
        ANSWERS.offset += ANSWERS.limit;
        let answers = document.createElement('div');
        data.forEach(el => {
            let answer = document.createElement('div');
            answer.classList = 'profile__answer';

            // get data in right format
            let date = el.created_at.split('T')[0].split('-').reverse().join('.');
            // remove img tags
            let name = el.name.replace(/<img[^>"']*((("[^"]*")|('[^']*'))[^"'>]*)*>/g,"");

            // check if name is only image
            if (name.replace(/<[^>]*>/g, "") === '') name = '<p>*картинка</p>';

            answer.innerHTML = `
            <div class='profile__answer-date'>
                <span>${date}</span>
            </div>
            <div class='profile__answer-text'>
                <a href='/profile/form/${el.hash}'>${name}</a>
            </div>
            <div class='profile__answer-amount'>
                <span>${el.answers_count} ответов</span><br>
            </div>
            <div class='profile__answer-delete'>
                <span data-form-id='${el.hash}'>Удалить</span>
            </div>`;

            answers.append(answer);
        })

        return answers;
    })
}

async function loadMoreAnswers() {
    if (this.scrollHeight - this.scrollTop - this.offsetHeight < 200) {
        // remove event while loading
        answersScrollBlock.removeEventListener('scroll', loadMoreAnswers);

        // display
        let answers = await getAnswers();
        // check if there are answers
        if (answers.children.length === 0) return;
        // append answers
        answersScrollBlock.append(answers);

        answersScrollBlock.addEventListener('scroll', loadMoreAnswers);
    }
}
