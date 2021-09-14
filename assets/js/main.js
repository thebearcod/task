document.addEventListener('click', function(event) {
    let target = event.target; 
    
    if (target.className == 'delete') {
        // console.log("Ajax delete ID:" + target.dataset.id);
        deleteContacts(target.dataset.id)
    } 
});

function deleteContacts(idContact) {
    const xhr = new XMLHttpRequest();
    xhr.responseType =	'json';
    xhr.open('POST','./assets/app/delete.php');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhr.addEventListener("readystatechange", () => {
        if(xhr.readyState === 4 && xhr.status === 200) { 
            if (!xhr.response) {
                console.log(xhr.response);
                return false;
            }
            // console.warn('Удалили запись'); 
            document.querySelector('.list').innerHTML = xhr.response.list;             
        }
    });
    let data = 'id='+idContact;
    xhr.send(data); 
}

let inputs = document.querySelectorAll('.form-control');
inputs.forEach(function(input) {
    input.addEventListener('keydown', function(event) {
        input.classList.remove('error');
        input.nextElementSibling.textContent = "";
        // console.log(input.value.length);
    });
});

function getErrorMessage(nameAttribute) {
    let message;
    switch (nameAttribute) {
        case 'name':
            message = 'Заполните Имя';
            break;
        
        case 'phone':
            message = 'Заполните Телефон';
            break;
    }
    return message;
}

function validateForm(form) {
    let errors = [];
    let elems = form.querySelectorAll('.form-control');  
    for(let i=0; i<elems.length; i++) {
        let error = "Некорректно заполнено поле";
        if (!elems[i].value) {
            elems[i].classList.add('error'); 
            error = getErrorMessage(elems[i].getAttribute('name'));
            errors.push(error);
            elems[i].nextElementSibling.textContent = error;
        } 
        if (elems[i].classList.contains('form-name') && elems[i].value.length > 32) {
            elems[i].classList.add('error'); 
            error = 'Имя слишком длинное';
            errors.push(error);
            elems[i].nextElementSibling.textContent = error;
        } else {
            let regexp = /[^а-яА-ЯёЁ\s]/;
            if (elems[i].classList.contains('form-name') && regexp.test(elems[i].value)) {
                elems[i].classList.add('error'); 
                errors.push(error);
                elems[i].nextElementSibling.textContent = error;
            } 
        }        
        if (elems[i].classList.contains('form-phone') && elems[i].value.length < 18) {
            elems[i].classList.add('error'); 
            error = 'Телефон должен состоять из 10 цифр';
            errors.push(error);
            elems[i].nextElementSibling.textContent = error;
        }             
    }

    if (errors.length == 0) {
        return true;
    } 

    return false;
}

let formSerf = document.forms['form-serf'];
formSerf.onsubmit = function(event) {
    event.preventDefault();
        const xhr = new XMLHttpRequest();
        xhr.responseType =	'json';
        xhr.open('POST','parsing-ajax.php');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhr.addEventListener("readystatechange", () => {
            if(xhr.readyState === 4 && xhr.status === 200) {
                if (!xhr.response) {
                    console.log(xhr.response);
                    return false;
                }
                // console.warn('Добавили запись');
                document.querySelector('.result').innerHTML = xhr.response.list;
                //formSerf.reset();
            }
        });
};

function getQueryString(formData){
    var pairs = [];
    for (var [key, value] of formData.entries()) {
        pairs.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
    }
    return pairs.join('&');
}

let formAdd = document.forms['form-add'];
formAdd.onsubmit = function(event) {
    event.preventDefault();
    if (validateForm(formAdd)) {
        const xhr = new XMLHttpRequest();
        xhr.responseType =	'json';
        xhr.open('POST','./assets/app/add.php');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhr.addEventListener("readystatechange", () => {
            if(xhr.readyState === 4 && xhr.status === 200) { 
                if (!xhr.response) {
                    console.log(xhr.response);
                    return false;
                }
                // console.warn('Добавили запись'); 
                document.querySelector('.list').innerHTML = xhr.response.list;
                formAdd.reset();          
            }
        });
        let data = new FormData(formAdd);
        xhr.send(getQueryString(data));
    }

};

function getQueryString(formData){
    var pairs = [];
    for (var [key, value] of formData.entries()) {
      pairs.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
    }
    return pairs.join('&');
}

// -- mask phone small ib
function mask(event) {
    console.log(this.value.length);
    let keyCode;
    event.keyCode && (keyCode = event.keyCode); 

    // let pos = this.selectionStart;
    // if (pos < 2) event.preventDefault();

    let matrix = "8 ___ ___ __ __";
    let i = 0;
    let def = matrix.replace(/\D/g, "");
    let val = this.value.replace(/\D/g, "");
    //--- уберем 7 или 8 вначале при вставке/автокомлит номера с 7 или 8
    if (event.type == 'input') {
        if (val.length >=11 && (val[1] == 7 || val[1] == 8 )) val = val[0]+val.substring(2,val.length);
    } 

    let new_value = matrix.replace(/[_\d]/g, function(a) {
        return i < val.length ? val.charAt(i++) || def.charAt(i) : a
    });

    i = new_value.indexOf("_");
    if (i != -1) {
        i < 4 && (i = 3);
        new_value = new_value.slice(0, i)
    }
    let reg = matrix.substr(0, this.value.length).replace(/_+/g,
        function(a) {
            return "\\d{1," + a.length + "}"
        }).replace(/[+()]/g, "\\$&");

    reg = new RegExp("^" + reg + "$");
    if (!reg.test(this.value) || this.value.length < 4 || keyCode > 47 && keyCode < 58) this.value = new_value;
    
    if (event.type == "blur" && this.value.length < 4)  this.value = "";
}

let input = document.querySelector('.form-phone');
input.addEventListener("input", mask);
input.addEventListener("focus", mask);
input.addEventListener("blur", mask);
input.addEventListener("keydown", mask);