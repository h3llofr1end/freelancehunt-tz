<?php

namespace app\core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = __DIR__ . "/views/$view";

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new FilesystemLoader(dirname(__DIR__) . '/views');
            $twig = new Environment($loader);
        }

        echo $twig->render($template, $args);
    }
}
