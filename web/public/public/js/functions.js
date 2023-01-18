function postJSON(url, data) {
    data['_token'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    return fetch(url, {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data),
    })
}

function getToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}
