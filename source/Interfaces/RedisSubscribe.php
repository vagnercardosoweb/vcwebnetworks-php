<?php

/*
 * VCWeb Networks <https://www.vcwebnetworks.com.br/>
 *
 * @author Vagner Cardoso <vagnercardosoweb@gmail.com>
 * @link https://github.com/vagnercardosoweb
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 25/01/2021 Vagner Cardoso
 */

namespace Core\Interfaces;

/**
 * Class RedisSubscribe.
 *
 * @author Vagner Cardoso <vagnercardosoweb@gmail.com>
 */
interface RedisSubscribe
{
    /**
     * @param mixed  $payload
     * @param string $channel
     *
     * @return mixed
     */
    public function __invoke($payload, string $channel);
}
