<?php

namespace Application\Controller;

use Application\Helper\FiltrationInterface;
use Application\Helper\MailInterface;
use Application\Helper\ValidationInterface;
use Application\Response\JsonResponse;

class ApiMailController
{
    private $filter;
    private $validator;
    private $mail;

    public function __construct(FiltrationInterface $filter, ValidationInterface $validator, MailInterface $mail)
    {
        $this->filter = $filter;
        $this->validator = $validator;
        $this->mail = $mail;

        $this->action();
    }

    private function action()
    {
        $data = $_POST;

        $this->filter->setData([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'message'   => $data['message']
        ]);

        $this->validator->setData($this->filter->getData());

        if($this->validator->isValid()) {

            $data = $this->validator->getData();

            $message = "Сообщение от " . $data['name'] . PHP_EOL;
            $message .= PHP_EOL;
            $message .= "Телефон: " . $data['phone'] . PHP_EOL;
            $message .= "Email: " . $data['email'] . PHP_EOL;
            $message .= PHP_EOL;
            $message .= PHP_EOL;
            $message .= $data['message'] . PHP_EOL;

            if(!$this->mail->send($message)) {
                $errors['mail'] = "Сообщение не отправлено";
            }
        }
        else {
            $errors = $this->validator->getErrors();
        }

        return new JsonResponse([ isset($errors) ? 'errors' : 'success' => isset($errors) ? $errors : "Сообщение отправлено" ]);
    }
}