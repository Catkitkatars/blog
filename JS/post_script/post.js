const filter_btn = document.querySelector('.button_filter');
const filter_block = document.querySelector('.filter_block');
const filter_close = document.querySelector('.filter_close_btn');
const btn_search = document.querySelector('.button_search');

const posts_block = document.querySelector('.posts');

const load_spinner = `<div style="height: 100px;"><svg class="spinner" viewBox="0 0 50 50">
<circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
</svg></div>`;

filter_btn.addEventListener('click', function() {
    filter_block.classList.toggle('block_hide');   
});

filter_close.addEventListener('click', function() {
    filter_block.classList.toggle('block_hide');
});


function render_divs(container, data_object) {
    posts_block.innerHTML = '';
    if(Object.keys(data_object).length === 0) {
        error_message = document.querySelector('.error_posts');


        if(!error_message) {
            const element = document.createElement('div');
            element.classList.add('error_posts');
            element.innerHTML = '<h3>Data not found</h3>';

            container.appendChild(element);
        }
    }
    else 
    {
        for (const key in data_object) {
            const element = document.createElement('div');
            element.classList.add('post');
            element.innerHTML = data_object[key];
    
            container.appendChild(element);
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const url = '/posts';

    posts_block.innerHTML = '';
    posts_block.innerHTML = load_spinner;

    const radio = filter_block.querySelector('.custom-radio[type="radio"]:checked'); 
    const most_likes = filter_block.querySelector('#most_likes').checked ?? false;
    const most_comments = filter_block.querySelector('#most_comments').checked ?? false;
    const author_post = filter_block.querySelector('#author_post').value;
    const titile_post = filter_block.querySelector('#titile_post').value;
    
    const data = new FormData();
    data.append('radio_option', radio.value);
    data.append('most_likes', most_likes);
    data.append('most_comments', most_comments);
    data.append('author_post', author_post);
    data.append('titile_post', titile_post);

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
            return console.log('беда');
        }
        else
        {
            return render_divs(posts_block, data.content)
        }
    })
    .catch(error => {
        console.error(error);
    });
});


btn_search.addEventListener('click', function(event) {
    event.preventDefault(); 
    const url = '/posts';

    posts_block.innerHTML = '';
    posts_block.innerHTML = load_spinner;

    const radio = filter_block.querySelector('.custom-radio[type="radio"]:checked'); 
    const most_likes = filter_block.querySelector('#most_likes').checked ?? false;
    const most_comments = filter_block.querySelector('#most_comments').checked ?? false;
    const author_post = filter_block.querySelector('#author_post').value;
    const titile_post = filter_block.querySelector('#titile_post').value;
    
    const data = new FormData();
    data.append('radio_option', radio.value);
    data.append('most_likes', most_likes);
    data.append('most_comments', most_comments);
    data.append('author_post', author_post);
    data.append('titile_post', titile_post);

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
            return console.log('беда');
        }
        else
        {
            return render_divs(posts_block, data.content)
        }
    })
    .catch(error => {
        console.error(error);
    });
});
