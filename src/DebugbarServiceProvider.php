<?php

namespace PhalconslayerLibs\Debugbar;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Application;
use Snowair\Debugbar\PhalconHttpDriver;
use Clarity\Providers\ServiceProvider;

/**
 * A service provider to run the debug bar.
 *
 * @author Daison Carino <daison12006013@gmail.com>
 */
class DebugbarServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $alias = 'debugbar';

    /**
     * Check if debug bar exists in the main config.
     *
     * @return bool
     */
    protected function hasConfig()
    {
        return config('debugbar', false) ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->publish([
            __DIR__.'/config' => base_path('config'),
        ], 'config');


        if ($this->hasConfig()) {
            $app      = di()->get('application');
            $debugbar = di()->get('debugbar');
            $router   = di()->get('router');

            $events_manager = $app->getEventsManager();

            if (! is_object($events_manager)) {
                $events_manager = new Manager();
            }

            $events_manager->attach('application:beforeSendResponse', function($event, $app, $response) use ($debugbar) {
                $debugbar->modifyResponse($response);
            });

            $events_manager->attach('application:afterStartModule', function ($event,$app,$module) use($debugbar){
                $debugbar->attachServices();
            });

            $app->setEventsManager($events_manager);

            $debugbar->boot();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        di()->set('config.debugbar', function () {
            return config('debugbar');
        }, $this->shared);

        if ($this->hasConfig()) {
            di()->set('debugbar', function () {
                $debugbar = new PhalconSlayerDebugbar($this);

                $debugbar->setHttpDriver(new PhalconHttpDriver());

                return $debugbar;
            }, $this->shared);

            require __DIR__.'/app/routes.php';
        }
    }
}
