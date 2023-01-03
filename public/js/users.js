const searchForm = document.querySelector(".cari input"),
    searchIcon = document.querySelector(".cari button"),
    usersList = document.querySelector(".list-pengguna");

searchIcon.onclick = () => {
    searchForm.classList.toggle("show");
    searchIcon.classList.toggle("active");
    searchForm.focus();
    if (searchForm.classList.contains("active")) {
        searchForm.value = "";
        searchForm.classList.remove("active");
    }
}

searchForm.onkeyup = () => {
    let cariUser = searchForm.value;
    if (cariUser != "") {
        searchForm.classList.add("active");
    } else {
        searchForm.classList.remove("active");
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/proakhir/public/user/search", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                usersList.innerHTML = data;
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("cariUser=" + cariUser);
}

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "http://localhost/proakhir/public/user/userlist", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (!searchForm.classList.contains("active")) {
                    usersList.innerHTML = data;
                }
            }
        }
    }
    xhr.send();
}, 500);