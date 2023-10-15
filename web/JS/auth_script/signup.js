
function toggle_password_visibility() {
    const password = document.getElementById('password');
    const password_confirm = document.getElementById('password_confirm');

    const password_checkbox = document.getElementById('password_checkbox');

    if (password_checkbox.checked) {
        password.type = 'text';
        password_confirm.type = 'text';
    } else {
        password.type = 'password';
        password_confirm.type = 'password';
    }
}

function add_input_error_class_ids(ids) {
    ids.forEach((id) => {
        const element = document.getElementById(id);
        if (element.tagName === 'INPUT' && element.type === 'checkbox') {
            element.classList.add('checkbox_error');
        } else if (element) {
            element.classList.add('input_error');
        }
    });
}


function send_request(key, value) {
    const url = '/auth/signup';

    const data = new FormData();

    if (Array.isArray(key) && Array.isArray(value)) {
        if (key.length !== value.length) {
            throw new Error('Error: The lengths of key and value arrays do not match.');
        }

        for (let i = 0; i < key.length; i++) {
            data.append(key[i], value[i]);
        }
    } else {
        data.append(key, value);
    }

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
            return false;
        }
        else
        {
            return true;
        }
    })
    .catch(error => {
        console.error(error);
    });
}

function html_error($response){

}


document.getElementById('login').addEventListener('blur', function() {
    let key = this.name;
    let value = this.value;
    let result = send_request(key, value);

    result.then(function (response) {
        if(response === false) {
            this.classList.add('input_error');

            const error_message_element = document.createElement('p');
            error_message_element.textContent = "This login is already in use";
            error_message_element.classList.add('error_message');

            if (!this.nextElementSibling.classList.contains('error_message')) {
                document.getElementById('login').insertAdjacentElement('afterend', error_message_element);
            }
        }
        else 
        {
            this.classList.remove('input_error');

            const error_message_element = document.getElementById('login');
            if (error_message_element.nextElementSibling.classList.contains('error_message')) {
                error_message_element.nextElementSibling.remove();
            }
        }
    }.bind(this)).catch(function (error) {
        console.error(error);
    });
});

document.getElementById('email').addEventListener('blur', function() {
    let key = this.name;
    let value = this.value;
    let result = send_request(key, value);

    result.then(function (response) {
        if(response === false) {
            this.classList.add('input_error');

            const error_message_element = document.createElement('p');
            error_message_element.textContent = "This email is already in use or incorrect";
            error_message_element.classList.add('error_message');

            if (!this.nextElementSibling.classList.contains('error_message')) {
                document.getElementById('email').insertAdjacentElement('afterend', error_message_element);
            }
        }
        else 
        {
            this.classList.remove('input_error');

            const error_message_element = document.getElementById('email');
            if (error_message_element.nextElementSibling.classList.contains('error_message')) {
                error_message_element.nextElementSibling.remove();
            }
        }
    }.bind(this)).catch(function (error) {
        console.error(error);
    });
});

document.getElementById('password_confirm').addEventListener('blur', function() {
    let keys = [document.getElementById('password').name, this.name];
    let values = [document.getElementById('password').value, this.value];

    let result = send_request(keys, values);

    result.then(function (response) {
        if(response === false) {
            this.classList.add('input_error');
            document.getElementById('password').classList.add('input_error');

            const error_message_element = document.createElement('p');
            error_message_element.textContent = "Passwords don't match";
            error_message_element.classList.add('error_message');

            if (!this.nextElementSibling.classList.contains('error_message')) {
                document.getElementById('password_confirm').insertAdjacentElement('afterend', error_message_element);
            }
        }
        else 
        {
            this.classList.remove('input_error');
            document.getElementById('password').classList.remove('input_error');

            const error_message_element = document.getElementById('password_confirm');
            if (error_message_element.nextElementSibling.classList.contains('error_message')) {
                error_message_element.nextElementSibling.remove();
            }
        }
    }.bind(this)).catch(function (error) {
        console.error(error);
    });
});



document.getElementById('register').addEventListener('click', function(event){
    event.preventDefault(); 
    const url = '/auth/signup';

    const data = new FormData();
    let checkbox = document.getElementById('checkbox').checked;

    data.append('login', login.value);
    data.append('email', email.value);
    data.append('password', password.value);
    data.append('password_confirm', password_confirm.value);
    data.append('user_name', user_name.value);
    data.append('user_surname', user_surname.value);
    data.append('country', country.value);
    data.append('slogan', slogan.value);
    data.append('checkbox', checkbox);

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
            // return console.log(data.message);
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

