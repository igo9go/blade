<?php

namespace Blade\View;

use Blade\View\Engines\PhpEngine;
use Blade\View\Engines\FileEngine;
use Blade\View\Engines\CompilerEngine;
use Blade\View\Engines\EngineResolver;
use Blade\View\Compilers\BladeCompiler;

class ViewServiceProvider
{
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function register()
    {
        $this->registerFactory();

        $this->registerViewFinder();

        $this->registerEngineResolver();
    }

    public function registerFactory()
    {
        $this->app->singleton('view', function ($app) {

            $resolver = $app['view.engine.resolver'];

            $finder = $app['view.finder'];

            $factory = $this->createFactory($resolver, $finder);

            $factory->setContainer($app);

            $factory->share('app', $app);

            return $factory;
        });
    }


    protected function createFactory($resolver, $finder)
    {
        return new Factory($resolver, $finder);
    }


    public function registerViewFinder()
    {
        $this->app->bind('view.finder', function ($app) {
            return new FileViewFinder($app['files'], $app['config']['view.paths']);
        });
    }


    public function registerEngineResolver()
    {
        $this->app->singleton('view.engine.resolver', function () {
            $resolver = new EngineResolver;

            foreach (['file', 'php', 'blade'] as $engine) {
                $this->{'register'.ucfirst($engine).'Engine'}($resolver);
            }

            return $resolver;
        });
    }

    public function registerFileEngine($resolver)
    {
        $resolver->register('file', function () {
            return new FileEngine;
        });
    }

    public function registerPhpEngine($resolver)
    {
        $resolver->register('php', function () {
            return new PhpEngine;
        });
    }

    public function registerBladeEngine($resolver)
    {
        $this->app->singleton('blade.compiler', function () {
            return new BladeCompiler(
                $this->app['files'], $this->app['config']['view.compiled']
            );
        });

        $resolver->register('blade', function () {
            return new CompilerEngine($this->app['blade.compiler']);
        });
    }
}
