'use strict';

const state = {};

document.addEventListener("DOMContentLoaded", init);

function init() {
    // устанавливаем блокировку отправки сообщения в дефолтное значение
    state.submitLock = false;

    submitListener();
    inputListener('name');
    inputListener('email');
    inputListener('phone');
    inputListener('message');
}

/** Прослушиваем кнопку "Отправить сообщение" */
function submitListener() {
    document.querySelector('#submit').addEventListener('click', function(e) {

        e.preventDefault();

        removeErrors([ 'name', 'email', 'phone', 'message' ]);

        const validator = new Validation();
        const filter = new Filtration();

        filter.setData({
            name: document.querySelector('[name="name"]').value.toString(),
            email: document.querySelector('[name="email"]').value.toString(),
            phone: document.querySelector('[name="phone"]').value.toString(),
            message: document.querySelector('[name="message"]').value.toString()
        });

        validator.setData(filter.getData());

        if(validator.isValid() && !state.submitLock) {
            state.submitLock = true;

            // данные валидны, отправляем запрос на сервер
            const request = new Request();

            request.setData(validator.getData());
            request.setUrl('/api/mail');
            request.sendRequest();
        }
        else {
            state.submitLock = false;

            // данные не валидны, выводим ошибки
            renderErrors(validator.getErrors());
        }

    });
}

/** Прослушиваем поля формы */
function inputListener(name) {
    document.querySelector('[name="' + name + '"]').addEventListener('input', function (e) {

        e.preventDefault();

        removeErrors([ name ]);

        const data = {};
        const validator = new Validation();
        const filter = new Filtration();

        data[name] = document.querySelector('[name="' + name + '"]').value.toString();

        filter.setData(data);

        validator.setData(filter.getData());

        if(!validator.isValid()) {
            renderErrors(validator.getErrors());
        }

    });
}

/** Рендеринг ошибок валидации */
function renderErrors(errors) {
    for (const [id,error] of Object.entries(errors)) {
        // добавляем класс error полю формы
        document.querySelector('[name="' + id + '"]').classList.add('error');

        let ErrorMessageElement = document.createElement('p');
        ErrorMessageElement.innerHTML = error;
        ErrorMessageElement.id = id + '-error';
        ErrorMessageElement.classList.add("error");

        // выводим сообщение об ошибке
        document.querySelector('[name="' + id + '"]').parentNode.insertBefore(ErrorMessageElement, document.querySelector('[name="' + id + '"]').nextSibling);
    }
}

/** Удаление ошибок валидации */
function removeErrors(errors) {
    for (const id of Object.values(errors)) {
        // убираем класс error у полей формы
        document.querySelector('[name="' + id + '"]').classList.remove('error');

        // удаляем сообщение об ошибке
        if(document.querySelector('#' + id + '-error') !== null) {
            document.querySelector('#' + id + '-error').remove();
        }
    }
}


/**
 * Класс фильтрации ввода
 */
class Filtration {

    /** Установить данные для фильтрации */
    setData(data) {
        this.data = data;
        this.applyFilters();
    }

    /** Получить данные после фильтрации */
    getData() {
        return this.data;
    }

    /** Подключение фильтров */
    applyFilters() {
        this.trimFilter();
        this.emailFilter();
    }

    /** Применяем фильтр Trim */
    trimFilter() {
        for(const [key,value] of Object.entries(this.data)) {
            this.data[key] = value.trim();
        }
    }

    /** Применяем фильтр для email */
    emailFilter() {
        if(this.data.email !== undefined && this.data.email !== null) {
            this.data.email = this.data.email.toLowerCase();
        }
    }
}

/**
 * Класс валидации ввода
 */
class Validation {

    constructor() {
        this.errors = {};
    }

    /** Установить данные для валидации */
    setData(data) {
        this.data = data;
    }

    /** Получить данные после валидации */
    getData() {
        return this.data;
    }

    /** Проверить валидны ли данные */
    isValid() {
        // Подключаем функции валидации
        for(const key of Object.keys(this.data)) {
            const fn = "isValid" + key.charAt(0).toUpperCase() + key.slice(1);

            if (typeof this[fn] === "function") {
                this[fn]();
            }
        }

        return Object.keys(this.errors).length === 0;
    }

    /** Получить ошибки валидации */
    getErrors() {
        return this.errors;
    }

    /** Проверить валидность имени */
    isValidName() {
        const is = 0 < this.data.name.length && this.data.name.length < 255;

        if(this.data.name.length === 0) {
            this.errors.name = "Поле имя должно быть заполнено";
        }
        else if(!is) {
            this.errors.name = "Ошибка в поле имя";
        }

        return is;
    }

    /** Проверить валидность телефона */
    isValidPhone() {
        const format = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/;
        const is = format.test(this.data.phone);

        if(this.data.phone.length === 0) {
            this.errors.phone = "Поле телефон должно быть заполнено";
        }
        else if(!is) {
            this.errors.phone = "Ошибка в поле телефон";
        }

        return is;
    }

    /** Проверить валидность email */
    isValidEmail() {
        const format = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        const is = format.test(this.data.email);

        if(this.data.email.length === 0) {
            this.errors.email = "Поле email должно быть заполнено";
        }
        else if(!is) {
            this.errors.email = "Ошибка в поле email";
        }

        return is;
    }

    /** Проверить валидность сообщения */
    isValidMessage() {
        const is = 0 < this.data.message.length && this.data.message.length < 255*1000;

        if(this.data.message.length === 0) {
            this.errors.message = "Поле сообщение должно быть заполнено";
        }
        else if(!is) {
            this.errors.message = "Ошибка в поле сообщение";
        }

        return is;
    }
}

/** Класс запроса на сервер */
class Request {

    /** Установить данные запроса */
    setData(data) {
        this.data = data;
    }

    /** Установить url запроса */
    setUrl(url) {
        this.url = url;
    }

    /** Отправить запрос */
    sendRequest() {
        fetch(this.url, {
            method: 'post',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: this.getBody()
        })
            .then(this.status)
            .then(this.json)
            .then(function(data) {
                state.submitLock = false;

                console.log('Ответ сервера:', data);

                if(data.success !== undefined) {
                    alert('Сообщение отправлено');
                } else {
                    alert('Произошла ошибка. Попробуйте отправить сообщение позже');
                }
            })
            .catch(function(error) {
                state.submitLock = false;

                alert('Произошла ошибка. Попробуйте отправить сообщение позже');
            });
    }

    /** Получить строку с данными */
    getBody() {
        let body = [];

        for (const [key,value] of Object.entries(this.data)) {
            body.push(key + '=' + value);
        }

        return body.join('&');
    }

    status(response) {
        if (response.status >= 200 && response.status < 300) {
            return Promise.resolve(response)
        } else {
            return Promise.reject(new Error(response.statusText))
        }
    }

    json(response) {
        return response.json()
    }
}