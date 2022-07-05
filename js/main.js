const checkbox = document.getElementById('myCheckbox')
const modalElement = document.getElementById("modalContent")
var myModal = new bootstrap.Modal(modalElement, {
    keyboard: true
})


function handleClick(checkbox) {
    var userId = checkbox.value;
    if (checkbox.checked) {
        console.log("checked")
        makeGetRequest(true, userId);
    } else {
        console.log("not checked")
        makeGetRequest(false, userId);
    }
}

function deleteUser(button) {
    var userId = button.value;
    console.log(userId);

    if (confirm("!!!Achtung User " + userId + " wirklich löschen?")) {
        deleteRequest(userId);
    } else {
        alert("User wurde nicht gelöscht");
    }


}

var deleteRequest = function(userId) {
    $.ajax({
        url: 'https://it-wissenstest.fb-dev.de/src/userApi.php',
        type: 'POST',
        data: { "userId": userId },
        success: function(data) {
            console.log(data); // Inspect this in your console
            location.reload(true);
        }
    });

};


var makeGetRequest = function(active, userId) {
    $.ajax({
        url: 'https://it-wissenstest.fb-dev.de/src/userApi.php',
        type: 'POST',
        data: { "id": userId, "active": active },
        success: function(data) {
            console.log(data); // Inspect this in your console

        }
    });
};





function refresh() {
    window.location.reload("refresh")
}


function hidePopUp() {
    var popup = document.getElementById("cookie-popup");
    popup.classList.toggle("hidden");
}

/*Password match */



var password = document.getElementById("password"),
    confirm_password = document.getElementById("confirm_password");

$('#passwordResetForm').submit(function(e) {
    e.preventDefault();
    validatePassword();
});

function validatePassword() {
    console.log(password.value);
    console.log(confirm_password.value);

    if (password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
        return false;
    } else {
        confirm_password.setCustomValidity('Password changed');
        $("#passwordResetForm")[0].submit();
        return true; // return false to cancel form action
    }
}

$('#passwordResetFormAdmin').submit(function(e) {
    e.preventDefault();
    chanchePassword();
});

function chanchePassword() {

    const btn = document.querySelector('#btn-pwdReset');

    chanchePwd = password.value;
    userId = id;
    console.log(userId);
    if (password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
        return false;
    } else {
        confirm_password.setCustomValidity('Password changed');
        $.ajax({
            url: 'https://it-wissenstest.fb-dev.de/src/userApi.php',
            type: 'POST',
            data: { "id": userId, "password": chanchePwd },
            success: function(data) {
                console.log(data); // Inspect this in your console

            }
        });
        return true; // return false to cancel form action
    }

}

function resetPupUp(e) {
    var hiddenContentId = e.currentTarget.getAttribute("data-hidden-content")
    const content = document.getElementById(hiddenContentId).innerHTML
    modalElement.getElementsByClassName("modal-body")[0].innerHTML = content
    myModal.show()
}


window.addEventListener("load", function() {
    let select = document.getElementById("userIds");
    var id = 0;

    select.addEventListener("change", function() {
        id = this.value;
        console.log("ID:" + id);
    });
})




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
    console.log(navlinks[i].href);
});


//SchulProjekt


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
    console.log(navlinks[i].href);
});


function check_all(name, el) {
    var box = el.form.elements[name];
    if (!box.length) box.checked = el.checked;
    else
        for (var i = 0; i < box.length; i++)
            if (!box[i].disabled) {
                box[i].checked = el.checked;
            }
}

function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("myShare");
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc";
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /*check if the two rows should switch place,
            based on the direction, asc or desc:*/
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            //Each time a switch is done, increase this count by 1:
            switchcount++;
        } else {
            /*If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again.*/
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}



var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
slider.oninput = function() {
    output.innerHTML = this.value;
}


//image zoom
function imageZoom(zoom_image){
    zoom_image = zoom_image;
    zoom_active = document.getElementsByClassName("zoom-active")[0];
    if (zoom_active) {
        zoom_active.classList.remove("zoom-active");
    }else{
        zoom_image.classList.add("zoom-active");
    }

}
