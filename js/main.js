const checkbox = document.getElementById('myCheckbox')
const modalElement = document.getElementById("modalContent")
var myModal = new bootstrap.Modal(modalElement, {
    keyboard: true
})

//funktion für User activ oder inactiv sestzen durch Checkbox
function handleClick(checkbox) {
    var userId = checkbox.value;
    if (checkbox.checked) {
        console.log("checked")
        makeGetRequest(true, userId);
    } else {
        //console.log("not checked")
        makeGetRequest(false, userId);
    }
}
//funktion für löschen eines Users anhand der Button-ID(User-ID)
function deleteUser(button) {
    var userId = button.value;
    //console.log(userId);

    if (confirm("!!!Achtung User " + userId + " wirklich löschen?")) {
        deleteRequest(userId);
    } else {
        alert("User wurde nicht gelöscht");
    }


}

var deleteRequest = function(userId) {
    //ajax Anfrage an Server um User zu Löschen anhand der User-ID
    $.ajax({
        url: 'https://it-wissenstest.fb-dev.de/src/userApi.php',
        type: 'POST',
        data: { "userId": userId },
        success: function(data) {
            // console.log(data); 
            location.reload(true);
        }
    });

};

//Anfrage an Server um User activ oder inactiv zusetzen
var makeGetRequest = function(active, userId) {
    $.ajax({
        url: 'https://it-wissenstest.fb-dev.de/src/userApi.php',
        type: 'POST',
        data: { "id": userId, "active": active },
        success: function(data) {
            //console.log(data); // Inspect this in your console

        }
    });
};
//refresh-Button
function refresh() {
    window.location.reload("refresh")
}

//PopUp verstecken 
function hidePopUp() {
    var popup = document.getElementById("cookie-popup");
    popup.classList.toggle("hidden");
}

//Passwort vergleich, ob beide Angaben übereinstimmen
var password = document.getElementById("password"),
    confirm_password = document.getElementById("confirm_password");

$('#passwordResetForm').submit(function(e) {
    e.preventDefault();
    validatePassword();
});

function validatePassword() {
    //console.log(password.value);
    // console.log(confirm_password.value);

    if (password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
        return false;
    } else {
        confirm_password.setCustomValidity('Password changed');
        $("#passwordResetForm")[0].submit();
        return true; // return false to cancel form action
    }
}

//Passwort zurücksetzten durch Admin
$('#passwordResetFormAdmin').submit(function(e) {
    e.preventDefault();
    chanchePassword();
});

function chanchePassword() {

    const btn = document.querySelector('#btn-pwdReset');

    chanchePwd = password.value;
    userId = id;
    //console.log(userId);
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
                //console.log(data); // Inspect this in your console

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
        //console.log("ID:" + id);
    });
})


function chatPopUp() {
    //console.log("TestPopUp");
    var popup = document.getElementById("chatPopUp");
    popup.classList.toggle("show");
}

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
    //console.log(navlinks[i].href);
});