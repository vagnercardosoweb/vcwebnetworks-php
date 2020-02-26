<?php

/*
 * VCWeb Networks <https://www.vcwebnetworks.com.br/>
 *
 * @author Vagner Cardoso <vagnercardosoweb@gmail.com>
 * @link https://github.com/vagnercardosoweb
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 26/02/2020 Vagner Cardoso
 */

if (!isset($_SERVER['DOCUMENT_ROOT'])) {
    $documentRoot = realpath($_SERVER['DOCUMENT_ROOT']);
} else {
    $documentRoot = realpath(dirname(__DIR__));
}

// Diretório raiz
define('ROOT', str_ireplace('\\', '/', $documentRoot));

// Diretório raiz da pasta publica
define('PUBLIC_FOLDER', ROOT.'/public_html');

/*
 * Diretório raiz da aplicação
 *
 * OBS: Esse diretório não pode ser acesso pela URL
 */

define('APP_FOLDER', ROOT.'/application');

// Diretório que armazena os recursos dos assets e views
define('RESOURCE_FOLDER', APP_FOLDER.'/resources');

// Define a URL base da aplicação
$schema = 'http';
$host = $_SERVER['HTTP_HOST'];

if (
    (!empty($_SERVER['HTTPS']) && 'on' == $_SERVER['HTTPS']) ||
    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && 'https' == $_SERVER['HTTP_X_FORWARDED_PROTO'])
) {
    $schema = 'https';
}

define('BASE_URL', "{$schema}://{$host}");

// Define a URL completa da aplicação
define('REQUEST_URI', $_SERVER['REQUEST_URI']);
define('FULL_URL', BASE_URL."{$_SERVER['REQUEST_URI']}");

// Carrega a aplicação
require_once APP_FOLDER.'/app/bootstrap.php';
