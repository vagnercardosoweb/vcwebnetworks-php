<?php

/*
 * VCWeb Networks <https://www.vcwebnetworks.com.br/>
 *
 * @author Vagner Cardoso <vagnercardosoweb@gmail.com>
 * @link https://github.com/vagnercardosoweb
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 26/02/2020 Vagner Cardoso
 */

use Core\App;

/**
 * @param string $buffer
 *
 * @return string
 */
function ob_output(string $buffer): string
{
    if (!preg_match('/localhost|.dev|.local/', $_SERVER['HTTP_HOST'])) {
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
        $buffer = preg_replace('/\r\n|\r|\n|\t/m', '', $buffer);
        $buffer = preg_replace('/^\s+|\s+$|\s+(?=\s)/m', '', $buffer);
    }

    return ob_gzhandler($buffer, 9);
}

// Minify html, js, css etc...
ob_start('ob_output');

// Cli server
if (PHP_SAPI == 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__.$url['path'];

    if (is_file($file)) {
        return false;
    }
}

// Autoload.
$autoload = APP_FOLDER.'/vendor/autoload.php';

if (!file_exists($autoload)) {
    die('composer not installed');
}

require_once "{$autoload}";

// Loader app
$app = App::getInstance();
$app->registerProviders();
$app->registerMiddleware();
$app->registerRoutes();
$app->registerEvents();
$app->run();

// Flush buffer
ob_end_flush();
