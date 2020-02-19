/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: main.js
 * Desc: main JavaScript file for Projekt
 *
 * Robin Jönsson
 * rojn1700
 * rojn1700@student.miun.se
 ******************************************************************************/

var xhr;

function main() {

    document.getElementById("loginButton").addEventListener('click', doLogin, false);
    document.getElementById("logoutButton").addEventListener('click', doLogout, false);
    let images = document.getElementsByClassName('image');
    for (let i = 0; i < images.length; i++) {
        images[i].addEventListener('click', processImageClick, false);
    }
    let folders = document.getElementsByClassName('folder');
    for (let i = 0; i < folders.length; i++) {
        folders[i].addEventListener('click', processFolderClick, false);
    }
    // Stöd för IE7+, Firefox, Chrome, Opera, Safari
    try {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xhr = new XMLHttpRequest();
        } else if (window.ActiveXObject) {
            // code for IE6, IE5
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        } else {
            throw new Error('Cannot create XMLHttpRequest object');
        }

    } catch (e) {
        alert('"XMLHttpRequest failed!' + e.message);
    }
}

window.addEventListener("load", main, false); // Connect the main function to window load event

/*******************************************************************************
 * Function doLogin
 ******************************************************************************/
function doLogin() {
    if (document.getElementById('uname').value != "" & document.getElementById('psw').value != "") {
        xhr.addEventListener('readystatechange', processLogin, false);
        xhr.open('GET', 'login.php', true);
        xhr.setRequestHeader("UNAME", document.getElementById('uname').value);
        xhr.setRequestHeader("PWD", document.getElementById('psw').value);
        xhr.send(null);
    }
}

/*******************************************************************************
 * Function doLogout
 ******************************************************************************/
function doLogout() {
    xhr.addEventListener('readystatechange', processLogout, false);
    xhr.open('GET', 'logout.php', true);
    xhr.send(null);
}

/*******************************************************************************
 * Function processLogin
 ******************************************************************************/
function processLogin() {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        //First we must remove the registered event since we use the same xhr object for login and logout
        xhr.removeEventListener('readystatechange', processLogin, false);
        var myResponse = JSON.parse(this.response);
        document.getElementById("psw").value = "";
        if (myResponse.logged_in) {
            location.reload();
        } else {
            alert(myResponse.responseText);
        }
    }
}

/*******************************************************************************
 * Function processLogout
 ******************************************************************************/
function processLogout() {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        //First we most remove the registered event since we use the same xhr object for login and logout
        xhr.removeEventListener('readystatechange', processLogout, false);
        if (window.location.pathname.search("userpage") !== -1) {
            window.location.replace("index.php");
        } else {
            location.reload();
        }
    }
}

/*******************************************************************************
 * Function processImageClick
 ******************************************************************************/
function processImageClick() {
    window.open(this.src);
}

/*******************************************************************************
 * Function processFolderClick
 ******************************************************************************/
function processFolderClick() {
    // Redirects with the proper folder path.
    if (location.href.search("path") !== -1) {
        location.href = location.href + "/" + this.parentElement.innerText.slice(1);
    } else if (location.href.search("[?]user") !== -1) {
        location.href = location.href + "&path=" + this.parentElement.innerText.slice(1);
    } else {
        location.href = location.href + "?path=" + this.parentElement.innerText.slice(1);
    }
}