$(document).ready(function() {

    current_page = window.location.href;
    navlinks = document.getElementsByClassName("nav-link");
    active_page = document.getElementsByClassName("active")[0];
    if (active_page) {
        active_page.classList.remove("active");
    }

    for (i = 0; i < navlinks.length; i++) {
        if (navlinks[i].href == current_page) {
            navlinks[i].classList.add("active");
            break;
        }
    }
});