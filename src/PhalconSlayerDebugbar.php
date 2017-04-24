<?php

namespace PhalconslayerLibs\Debugbar;

use Phalcon\Version;
use Phalcon\Registry;
use Phalcon\Http\Response;
use Phalcon\Events\Manager;
use Snowair\Debugbar\PhalconDebugbar;
use Snowair\Debugbar\Phalcon\View\VoltFunctions;

class PhalconSlayerDebugbar extends PhalconDebugbar
{
    /**
     * @param $view
     *
     * @throws \DebugBar\DebugBarException
     */
    public function attachView($view)
    {
        if (isset($this->collectors['views'])) {
            return;
        }

        if (is_string($view)) {
            $view = $this->di->get($view);
        }

        $engines = $view->getRegisteredEngines();

        if (isset($engines['.volt'])) {
            $volt = $engines['.volt'];

            if (is_object($volt)) {
                if ($volt instanceof \Closure) {
                    $volt = $volt($view, $this->di);
                }
            } elseif (is_string($volt)) {
                if (class_exists($volt)) {
                    $volt = new $volt($view, $this->di);
                } elseif ($this->di->has($volt)) {
                    $volt = $this->di->getShared($volt, array($view, $this->di));
                }
            }

            $engines['.volt'] = $volt;

            $view->registerEngines($engines);
            $volt->getCompiler()->addExtension(new VoltFunctions($this->di));
        }

        if (! $this->shouldCollect('view', true)) {
            return;
        }

        $viewProfiler = new Registry();

        $viewProfiler->templates=array();
        $viewProfiler->engines = $view->getRegisteredEngines();

        $config = $this->config;

        $eventsManager = $view->getEventsManager();

        if ( !is_object( $eventsManager ) ) {
            $eventsManager = new Manager();
        }

        $eventsManager->attach('view:beforeRender', function($event,$view) use ($viewProfiler) {
            $viewProfiler->startRender= microtime(true);

        });

        $eventsManager->attach('view:afterRender', function($event,$view) use ($viewProfiler, $config) {
            $viewProfiler->stopRender= microtime(true);

            if ( $config->options->views->get( 'data', false)) {
                $viewProfiler->params = $view->getParamsToView();
            } else {
                $viewProfiler->params = null;
            }
        });

        $eventsManager->attach('view:beforeRenderView', function ($event, $view) use ($viewProfiler) {
            $viewFilePath = $view->getActiveRenderPath();
            if (Version::getId()>=2000140) {
                if ( !$view instanceof \Phalcon\Mvc\ViewInterface && $view instanceof \Phalcon\Mvc\ViewBaseInterface) {
                    $viewFilePath = realpath($view->getViewsDir()).DIRECTORY_SEPARATOR.$viewFilePath;
                }
            }elseif( $view instanceof Simple){
                $viewFilePath = realpath($view->getViewsDir()).DIRECTORY_SEPARATOR.$viewFilePath;
            }

            $templates = $viewProfiler->templates;
            $templates[$viewFilePath]['startTime'] = microtime(true);
            $viewProfiler->templates =  $templates;
        });

        $eventsManager->attach('view:afterRenderView', function($event, $view) use ($viewProfiler) {
            $viewFilePath = $view->getActiveRenderPath();

            if (Version::getId() >= 2000140) {
                if ( !$view instanceof \Phalcon\Mvc\ViewInterface && $view instanceof \Phalcon\Mvc\ViewBaseInterface) {
                    $viewFilePath = realpath($view->getViewsDir()).DIRECTORY_SEPARATOR.$viewFilePath;
                }
            } elseif ($view instanceof Simple) {
                $viewFilePath = realpath($view->getViewsDir()).DIRECTORY_SEPARATOR.$viewFilePath;
            }

            $templates = $viewProfiler->templates;
            $templates[$viewFilePath]['stopTime'] = microtime(true);
            $viewProfiler->templates =  $templates;
        });

        $view->setEventsManager($eventsManager);

        $collector = new ViewCollector($viewProfiler,$view);

        $this->addCollector($collector);
    }

    /**
     * Injects the web debug toolbar into the given Response.
     * Based on https://github.com/symfony/WebProfilerBundle/blob/master/EventListener/WebDebugToolbarListener.php
     *
     * @param Response $response
     */
    public function injectDebugbar(Response $response)
    {
        $content = $response->getContent();

        $renderer = $this->getJavascriptRenderer();

        $openHandlerUrl = $this->di->get('url')->getStatic(array('for' => 'debugbar.openhandler'));

        $renderer->setOpenHandlerUrl($openHandlerUrl);

        $renderedContent = $renderer->renderHead() . $renderer->render();

        $pos = strripos($content, '</body>');

        if (false !== $pos) {
            $content = substr($content, 0, $pos) . $renderedContent . substr($content, $pos);
        } else {
            $content = $content . $renderedContent;
        }

        $response->setContent($content);
    }

    /**
     * Returns a JavascriptRenderer for this instance
     *
     * @param string $baseUrl
     * @param null   $basePath
     *
     * @return JsRender
     */
    public function getJavascriptRenderer($baseUrl = null, $basePath = null)
    {
        if ($this->jsRenderer === null) {
            $this->jsRenderer = new JsRender($this, $baseUrl, $basePath);
            $this->jsRenderer->setUrlGenerator($this->di->get('url'));
        }

        return $this->jsRenderer;
    }
}
