<?php

/*
 * VCWeb Networks <https://www.vcwebnetworks.com.br/>
 *
 * @author Vagner Cardoso <vagnercardosoweb@gmail.com>
 * @link https://github.com/vagnercardosoweb
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 25/02/2020 Vagner Cardoso
 */

namespace Core;

use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class View.
 *
 * @author Vagner Cardoso <vagnercardosoweb@gmail.com>
 */
class View
{
    /**
     * @var \Twig\Loader\FilesystemLoader
     */
    protected $loader;

    /**
     * @var \Twig\Environment
     */
    protected $environment;

    /**
     * @param string|array $path
     * @param array        $options
     *
     * @throws \Twig\Error\LoaderError
     */
    public function __construct($path, array $options = [])
    {
        $path = is_string($path) ? [$path] : $path;
        $this->loader = $this->createLoader($path);
        $this->environment = new \Twig\Environment($this->loader, $options);
    }

    /**
     * @param Response $response
     * @param string   $template
     * @param array    $context
     * @param int      $status
     *
     * @return Response
     */
    public function render(Response $response, string $template, array $context = [], int $status = StatusCode::HTTP_OK): Response
    {
        $response = $response->withStatus($status);
        $response->getBody()->write($this->fetch($template, $context));

        return $response;
    }

    /**
     * @param string $template
     * @param array  $context
     *
     * @return string
     */
    public function fetch(string $template, array $context = [])
    {
        $removedExtension = $this->removeExtension($template);

        if ($this->exists("{$removedExtension}/index.twig")) {
            $template = sprintf('%s/%s', $removedExtension, 'index');
        }

        $template = $this->normalizeExtension($template);

        return $this->environment->render($template, $context);
    }

    /**
     * @param string $template
     *
     * @return bool
     */
    public function exists(string $template): bool
    {
        return $this->loader->exists($this->normalizeExtension($template));
    }

    /**
     * @param \Twig\Extension\ExtensionInterface $extension
     *
     * @return $this
     */
    public function addExtension(\Twig\Extension\ExtensionInterface $extension)
    {
        $this->environment->addExtension($extension);

        return $this;
    }

    /**
     * @param string   $name
     * @param callable $callable
     * @param array    $options
     *
     * @return $this
     */
    public function addFunction(string $name, $callable, array $options = ['is_safe' => ['all']])
    {
        $this->environment->addFunction(new \Twig\TwigFunction($name, $callable, $options));

        return $this;
    }

    /**
     * @param string   $name
     * @param callable $callable
     * @param array    $options
     *
     * @return $this
     */
    public function addFilter(string $name, $callable, array $options = ['is_safe' => ['all']])
    {
        $this->environment->addFilter(new \Twig\TwigFilter($name, $callable, $options));

        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function addGlobal(string $name, $value)
    {
        $this->environment->addGlobal($name, $value);

        return $this;
    }

    /**
     * @return \Twig\Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param string $template
     *
     * @return string
     */
    private function normalizeExtension(string $template): string
    {
        $template = $this->removeExtension($template);
        $template = str_replace('.', '/', $template);

        return sprintf('%s.%s', $template, 'twig');
    }

    /**
     * @param string $template
     *
     * @return string
     */
    private function removeExtension(string $template): string
    {
        return preg_replace('/\.twig$/', '', $template);
    }

    /**
     * @param array $paths
     *
     * @throws \Twig\Error\LoaderError
     *
     * @return \Twig\Loader\FilesystemLoader
     */
    private function createLoader(array $paths)
    {
        $loader = new \Twig\Loader\FilesystemLoader();

        foreach ($paths as $namespace => $path) {
            if (is_string($namespace)) {
                $loader->setPaths($path, $namespace);
            } else {
                $loader->addPath($path);
            }
        }

        return $loader;
    }
}
