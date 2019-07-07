<?php

namespace Application\Helper;

/**
 * Интерфейс фильтрации
 *
 * Interface FiltrationInterface
 * @package Application\Helper
 */
interface FiltrationInterface
{
    /**
     * Установить данные для фильтрации
     *
     * @param array $data
     * @return void
     */
    public function setData(array $data): void;

    /**
     * Получить данные после фильтрации
     *
     * @return array
     */
    public function getData(): array;
}