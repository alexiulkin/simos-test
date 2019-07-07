<?php
/**
 * Date: 05.07.2019
 * Time: 14:16
 */

namespace Application\Helper;


interface MailInterface
{
    /**
     * Отправить email
     *
     * @param string $message Сообщение
     * @return bool
     */
    public function send(string  $message): bool;
}