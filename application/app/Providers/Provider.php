<?php

/*
 * VCWeb Networks <https://www.vcwebnetworks.com.br/>
 *
 * @author Vagner Cardoso <vagnercardosoweb@gmail.com>
 * @link https://github.com/vagnercardosoweb
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 26/02/2020 Vagner Cardoso
 */

namespace App\Providers;

use Core\App;
use Core\Interfaces\ServiceProvider;

/**
 * Class Provider.
 *
 * @property \Slim\Collection             $settings
 * @property \Slim\Http\Environment       $environment
 * @property \Slim\Http\Request           $request
 * @property \Slim\Http\Response          $response
 * @property \Slim\Router                 $router
 * @property \Core\View                   $view
 * @property \Core\Session\Session|object $session
 * @property \Core\Session\Flash|object   $flash
 * @property \Core\Mailer\Mailer          $mailer
 * @property \Core\Password\Password      $hash
 * @property \Core\Encryption             $encryption
 * @property \Core\Jwt                    $jwt
 * @property \Core\Logger                 $logger
 * @property \Core\Event                  $event
 * @property \Core\Database\Database      $db
 * @property \Core\Database\Database      $database
 * @property \Core\Curl\Curl              $curl
 * @property \Core\Redis                  $redis
 * @property \Core\Cache\Cache            $cache
 *
 * @author Vagner Cardoso <vagnercardosoweb@gmail.com>
 */
abstract class Provider implements ServiceProvider
{
    /**
     * @var \Core\App
     */
    protected $app;

    /**
     * @param \Core\App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->app->resolve($name);
    }
}
