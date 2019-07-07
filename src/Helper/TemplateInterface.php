<?php

namespace Application\Helper;

/**
 * Интерфейс шаблонизатора
 *
 * Interface TemplateInterface
 * @package Application\Helper
 */
interface TemplateInterface
{
    /**
     * @param string $name
     * @return string
     */
    public function render(string $name): string;
}