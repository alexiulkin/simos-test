<?php

namespace Application\Helper;

/**
 * Интерфейс валидации
 *
 * Interface ValidationInterface
 * @package Application\Helper
 */
interface ValidationInterface
{
    /**
     * Установить данные для валидации
     *
     * @param array $data
     * @return void
     */
    public function setData(array $data): void;

    /**
     * Получить данные после валидации
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Проверить валидны ли данные
     *
     * @return bool
     */
    public function isValid(): bool;

    /**
     * Получить ошибки валидации
     *
     * @return array
     */
    public function getErrors(): array;
}