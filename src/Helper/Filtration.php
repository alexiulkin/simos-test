<?php

namespace Application\Helper;

/**
 * Class Filtration
 * @package Application\Helper
 */
class Filtration implements FiltrationInterface
{
    /** @var array */
    private $data;

    /**
     * Установить данные для фильтрации
     *
     * @param array $data
     * @return void
     */
    public function setData(array $data): void
    {
        $this->data = $data;

        $this->applyFilters();
    }

    /**
     * Получить данные после фильтрации
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Подключение фильтров
     *
     * @return void
     */
    private function applyFilters(): void
    {
        $this->trimFilter();
        $this->emailFilter();
    }

    /**
     * Применяем фильтр Trim
     *
     * @return void
     */
    private function trimFilter(): void
    {
        foreach($this->data as $key => $value) {
            $this->data[$key] = trim($value);
        }
    }

    /**
     * Применяем фильтр для email
     *
     * @return void
     */
    private function emailFilter(): void
    {
        if(!empty($this->data['email'])) {
            $this->data['email'] = mb_strtolower($this->data['email']);
        }
    }
}
