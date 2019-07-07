<?php

namespace Application\Helper;

/**
 * Class Validation
 * @package Application\Helper
 */
class Validation implements ValidationInterface
{
    private $data;
    private $errors;

    public function __construct()
    {
        $this->errors = [];
    }

    /**
     * Получить данные после валидации
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Установить данные для валидации
     *
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * Проверить валидны ли данные
     *
     * @return bool
     */
    public function isValid(): bool
    {
        // Подключаем функции валидации
        foreach ($this->data as $key => $value) {
            $fn = 'isValid' . ucfirst($key);

            if(method_exists($this,$fn)) {
                $this->{$fn}();
            }
        }

        return count($this->errors) == 0;
    }

    /**
     * Получить ошибки валидации
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Проверить валидность имени
     *
     * @return bool
     */
    private function isValidName(): bool
    {
        $length = mb_strlen($this->data['name']);

        $is = 0 < $length && $length < 255;

        if($length == 0) {
            $this->errors['name'] = "Поле имя должно быть заполнено";
        }
        else if(!$is) {
            $this->errors['name'] = "Ошибка в поле имя";
        }

        return $is;
    }

    /**
     * Проверить валидность телефона
     *
     * @return bool
     */
    private function isValidPhone(): bool
    {
        $pattern = "/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i";

        $is = preg_match($pattern, $this->data['phone']);

        if(mb_strlen($this->data['phone']) == 0) {
            $this->errors['phone'] = "Поле телефон должно быть заполнено";
        }
        else if(!$is) {
            $this->errors['phone'] = "Ошибка в поле телефон";
        }

        return $is;
    }

    /**
     * Проверить валидность email
     *
     * @return bool
     */
    private function isValidEmail(): bool
    {
        $pattern = "/^(([^<>()\[\]\\.,;:\s@\"]+(\.[^<>()\[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i";

        $is = preg_match($pattern, $this->data['email']);

        if(mb_strlen($this->data['email']) == 0) {
            $this->errors['email'] = "Поле email должно быть заполнено";
        }
        else if(!$is) {
            $this->errors['email'] = "Ошибка в поле email";
        }

        return $is;
    }

    /**
     * Проверить валидность сообщения
     *
     * @return bool
     */
    private function isValidMessage(): bool
    {
        $length = mb_strlen($this->data['message']);

        $is = 0 < $length && $length < 255*1000;

        if($length == 0) {
            $this->errors['message'] = "Поле сообщение должно быть заполнено";
        }
        else if(!$is) {
            $this->errors['message'] = "Ошибка в поле сообщение";
        }

        return $is;
    }

}