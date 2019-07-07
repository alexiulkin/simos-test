<?php

namespace Application\Helper;

use Application\Exception\LogicException;
use Exception;

/**
 * Class Template
 * @package Application\Helper
 */
class Template implements TemplateInterface
{
    /** @var string */
    private $dir;

    public function __construct()
    {
        $this->dir = ROOT_DIR . 'templates';
    }

    /**
     * @param string $name
     * @throws \Exception
     * @return string
     */
    public function render(string $name): string
    {
        $items = explode('/', $name);

        $file = $this->dir . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $items) . '.phtml';

        if (!file_exists($file)) {
            throw new LogicException(sprintf(
                'Template "%s" not found',
                $name
            ));
        }

        try {
            $level = ob_get_level();
            ob_start();

            include $file;

            $content = ob_get_clean();

            return $content;

        } catch (Exception $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }

            throw $e;
        }
    }
}