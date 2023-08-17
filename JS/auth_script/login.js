function toggle_password_visibility() {
    const password = document.getElementById('password');

    const password_checkbox = document.getElementById('password_checkbox');

    if (password_checkbox.checked) {
        password.type = 'text';
    } else {
        password.type = 'password';
    }
}

function add_input_error_class_ids(ids) {
    ids.forEach((id) => {
        const element = document.getElementById(id);
        if (element) {
            element.classList.add('input_error');
        }
    });
}

document.getElementById('enter').addEventListener('click', function(event){
    event.preventDefault(); 
    const url = '/auth/login';

    const data = new FormData();

    data.append('login', login.value);
    data.append('password', password.value);

    const request_options = {
        method: 'POST',
        body: data
    };

    return fetch(url, request_options)
    .then(response => {
        if (response.ok) {
        return response.json();
        } else {
        throw new Error('Error:' + response.status);
        }
    })
    .then(data => {
        if (!data.success) {
            add_input_error_class_ids(data.message);
        }
        else
        {
            window.location.href = "http://localhost:8000/";
        }
    })
    .catch(error => {
        console.error(error);
    });
}) 