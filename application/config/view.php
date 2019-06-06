<?php

/**
 * VCWeb Networks <https://www.vcwebnetworks.com.br/>.
 *
 * @author    Vagner Cardoso <vagnercardosoweb@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @copyright 31/05/2019 Vagner Cardoso
 */
use Core\App;

return [
    /*
     * Options
     *
     * Configura as opções padões do twig
     */

    'options' => [
        'debug' => true,
        'charset' => 'UTF-8',
        'strict_variables' => false,
        'autoescape' => 'html',
        'cache' => ('production' == env('APP_ENV') ? APP_FOLDER.'/storage/cache' : false),
        'auto_reload' => true,
        'optimizations' => -1,
    ],

    /*
     * Templates
     *
     * Define os templates no carregamento das views
     *
     * OBS: Não altere os nomes dos indice e caso altere o caminho do template
     *      deverá verificar e renomear o nome da pasta.
     */

    'templates' => [
        'web' => RESOURCE_FOLDER.'/views/web',
        'error' => RESOURCE_FOLDER.'/views/error',
        'mail' => RESOURCE_FOLDER.'/views/mail',
    ],

    /*
     * Helpers & Functions
     *
     * Registra funções e filtros para usar na view
     */

    'registers' => [
        /*
         * Funções
         */

        'functions' => [
            'asset' => 'asset',
            'asset_content' => 'asset_content',
            'config' => 'config',
            'path_for' => '\Core\Router::pathFor',
            'is_current_router' => '\Core\Router::isCurrent',
            'has_current_router' => '\Core\Router::hasCurrent',
            'has_container' => function ($name, $params = []) {
                return App::getInstance()->resolve($name, $params);
            },
            'csrf_token' => function ($input = true) {
                $token = App::getInstance()->resolve('encryption')->encrypt([
                    'token' => uniqid(rand(), true),
                    'expired' => time() + (60 * 60 * 24),
                ]);

                return $input
                    ? "<input type='hidden' name='_csrfToken' id='_csrfToken' value='{$token}'/>"
                    : $token;
            },
        ],

        /*
         * Filtros
         */

        'filters' => [
            'is_string' => 'is_string',
            'is_array' => 'is_array',
            'get_day' => 'get_day',
            'get_month' => 'get_month',
        ],
    ],
];
