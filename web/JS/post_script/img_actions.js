const image_input = document.querySelector(".img_input");
const image_preview = document.querySelector(".img_preview");

const submit_button = document.querySelector('.button_add');

let current_image = null;

function set_timeout(block_class_name, timer_ms) {
    const block = document.querySelector(block_class_name);

    setTimeout(function() {
        block.remove();
    }, timer_ms);
}


image_input.addEventListener("change", function () {
    const number_of_children = image_preview.childElementCount;
    const files = image_input.files;

    if(number_of_children < 5  && files.length <= 5) {
        
        for (const file of files) {
            const max_size_in_bytes = 5 * 1024 * 1024; 

            if (file.size > max_size_in_bytes) {
                const error_block = document.createElement('p');
                error_block.classList.add('error_message');
                error_block.textContent = 'The weight of the image is more than 5 mb';
                image_input.insertAdjacentElement('afterend', error_block);
                set_timeout('.error_message', 5000);
                return;
            }

            const reader = new FileReader();
    
            reader.onload = function(event) {
                const image_data = event.target.result;
    
                const img = document.createElement("img");
                img.src = image_data;
                img.classList.add("preview_image");
    
                const preview_action = document.createElement('div');
                preview_action.classList.add('preview_action');
    
                const delete_button = document.createElement("i");
                delete_button.classList.add('material-symbols-outlined', 'trash_button');
                delete_button.textContent = "delete";
    
                delete_button.addEventListener('click', function() {
                    const preview_block = this.closest('.preview_block');
                    if (preview_block) {
                        preview_block.remove();
                    }
                })
    
                const update_button = document.createElement('i');
                update_button.classList.add('material-symbols-outlined', 'update_button');
                update_button.textContent = "refresh";
    
                const update_input = document.createElement('input');
                update_input.type = 'file';
                update_input.accept = 'image/*';
    
                update_input.addEventListener("change", function () {
                    const new_image_file = update_input.files[0];
                    const new_reader = new FileReader();

                    if (new_image_file.size > max_size_in_bytes) {
                        const error_block = document.createElement('p');
                        error_block.classList.add('error_message');
                        error_block.textContent = 'The weight of the image is more than 5 mb';
                        image_input.insertAdjacentElement('afterend', error_block);
                        const preview_block = this.closest('.preview_block');
                        preview_block.remove();
                        set_timeout('.error_message', 5000);
                        return;
                    }
    
                    new_reader.onload = function(event) {
                        const new_image_data = event.target.result;
                        img.src = new_image_data; 
                    };
    
                    new_reader.readAsDataURL(new_image_file);
                });
    
                update_button.addEventListener("click", function () {
                    update_input.click(); 
                    current_image = img; 
                });
    
                const preview_block = document.createElement('div');
                preview_block.classList.add('preview_block');
    
                preview_action.appendChild(update_button);
                preview_action.appendChild(update_input);
                preview_action.appendChild(delete_button);
    
                preview_block.appendChild(img);
                preview_block.appendChild(preview_action);
                image_preview.appendChild(preview_block);
            };
    
            reader.readAsDataURL(file);
        }
    }
    else 
    {
        const error_block = document.createElement('p');
        error_block.classList.add('error_message');
        error_block.textContent = 'No more than 5 photos';
        image_input.insertAdjacentElement('afterend', error_block);
        set_timeout('.error_message', 5000);
    }
});

submit_button.addEventListener('click', function(event) {
    event.preventDefault();
    const url = '/posts/add_post';

    const preview_blocks = image_preview.querySelectorAll(".preview_block");
    const uploaded_files = [];
    
    for (const preview_block of preview_blocks) {
        const img = preview_block.querySelector("img");
        const file_data = img.src;

        uploaded_files.push(file_data);
    }

    const form = new FormData();
    form.append("title", post_title.value);
    form.append("text", post_text.value);

    for (const file_data of uploaded_files) {
        form.append("uploaded_files[]", file_data);
    }

    const request_options = {
        method: 'POST',
        body: form
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
            return data;
        }
    })
    .catch(error => {
        console.error(error);
    });
});


