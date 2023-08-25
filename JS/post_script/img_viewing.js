document.addEventListener('click', function(event) {
    const clicked_element = event.target;
    const img_view = document.querySelector(".img_view");

    if(clicked_element.classList.contains("preview_image")) {
        
        img_view.style.display = "flex";

        img = document.createElement("img");
        img.src = clicked_element.src;

        img_view.appendChild(img);
    }
    if(clicked_element.classList.contains("view_img_close_btn")) {
        img_view.style.display = "none";
        let last_child = img_view.lastChild;
        img_view.removeChild(last_child);
    }
})