const input_title = document.getElementById('post_title');
const input_textarea = document.getElementById('post_text');

const title_counter = document.querySelector('.post_title_counter');
const textarea_counter = document.querySelector('.post_textarea_counter')
let over_limit = false;

input_title.addEventListener('input', function(event) {
    const title_value = this.value;
    let title_length = title_value.length;

    title_counter.textContent = title_length;
    
    if (title_length >= 50 && !over_limit) {
        over_limit = true;
        title_counter.classList.add('error_message');
        input_title.addEventListener("keydown", keydown_handler);
    } else if (title_length < 50 && over_limit) {
        over_limit = false;
        title_counter.classList.remove('error_message');
        input_title.removeEventListener("keydown", keydown_handler);
    }
});

input_textarea.addEventListener('input', function(event) {
    const textarea_value = this.value;
    let textarea_length = textarea_value.length;

    textarea_counter.textContent = textarea_length;
    
    if (textarea_length >= 5000 && !over_limit) {
        over_limit = true;
        textarea_counter.classList.add('error_message');
        input_textarea.addEventListener("keydown", keydown_handler);
    } else if (textarea_length < 5000 && over_limit) {
        over_limit = false;
        textarea_counter.classList.remove('error_message');
        input_textarea.removeEventListener("keydown", keydown_handler);
    }
});

function keydown_handler(event) {
    if (
        (event.key !== "Backspace" &&
        event.key !== "Delete" &&
        event.key !== "ArrowLeft" &&
        event.key !== "ArrowRight" &&
        event.key !== "Tab") &&
        !(event.ctrlKey && event.key === "a") &&
        !(event.metaKey && event.key === "a")
    ) {
        event.preventDefault();
    }
}
