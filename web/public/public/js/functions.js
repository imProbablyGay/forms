

function postJSON(url, data) {
    return fetch(url, {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': getToken(),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
}
function getToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

function getEl(el, className) {
    let _el = el;
    while (true) {
        if (_el.classList.contains(className)) {
            return _el;
        };
        if (_el == null || _el.tagName == "HEAD") return null;
        _el = _el.previousElementSibling ?? _el.parentElement;

    }
}

function getParentEl(el, className, step) {
    let _el = el;
    let count = 0;
    while (count <= step) {
        if (_el.classList.contains(className)) {
            return _el;
        };

        count++;
        if (_el == null || _el.tagName == "HEAD") return null;
        _el = _el.parentElement;

    }
}

function showAlertModal(text) {
    let successModal = new bootstrap.Modal(document.getElementById('alert_modal'));
    document.getElementById('alert_modal').querySelector('h4').innerHTML = text;
    successModal.show()
}

function showConfirmRejectModal(text, callback) {
    let successModal = new bootstrap.Modal(document.getElementById('confirm_reject_modal'));
    document.getElementById('confirm_reject_modal').querySelector('h4').innerHTML = text;
    successModal.show()

    // add event if confirm
    document.getElementById('confirm_reject_modal').querySelector('.modal-send-footer').onclick = callback;
}

function replaceProfilePicture() {
    Array.from(document.querySelectorAll('.profile-picture')).forEach(el => {
        var req = new XMLHttpRequest();
        req.open('get', el.src, false);
        req.send(null);
        if (req.status == 404) el.src = '/img/users/icons/default-profile-picture.webp';
    })
}
replaceProfilePicture()


function getQueryArg(name) {
    const params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
      });
      // Get the value of "some_key" in eg "https://example.com/?some_key=some_value"
      return params[name]; // "some_value"
}
