<?php

/*
 * VCWeb Networks <https://www.vcwebnetworks.com.br/>
 *
 * @author Vagner Cardoso <vagnercardosoweb@gmail.com>
 * @link https://github.com/vagnercardosoweb
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 25/01/2021 Vagner Cardoso
 */

$app->group([
    'path' => '/console',
    'namespace' => 'Console/',
], function (Core\App $app) {
    $app->route('*', '', 'IntroController');
});
