<?php

define('ROOT_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);

$items = array(
    'Application\\' => ROOT_DIR . 'src'
);

/**
 * @param string $class
 * @return void
 */
spl_autoload_register(function ($class) use ($items) {

    foreach($items as $prefix => $base_dir) {

        $len = strlen($prefix);

        $relative_class = substr($class, $len);

        $file = $base_dir . DIRECTORY_SEPARATOR . str_replace('\\', '/', $relative_class) . '.php';

        if (file_exists($file)) {
            include $file;
        }
    }
});