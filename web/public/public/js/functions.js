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
