<?php

namespace PhalconslayerLibs\Debugbar;

use Phalcon\Di;
use Phalcon\Mvc\Application;
use Snowair\Debugbar\JsRender as BaseJsRender;

class JsRender extends BaseJsRender
{
    public function renderHead()
    {
        if (! $this->url) {
            return parent::renderHead();
        }

        $time = time();
        $html = '';
        $di = Di::getDefault();

        $app = $di->get('application');

        $dispatcher = $di->get('dispatcher');

        $m = $dispatcher->getModuleName();

        if (! $m) {
            $m = $di->get('request')->get('m');
        }

        if (! $m) {
            $m = $app->getDefaultModule();
        }

        $this->url = $di->get('url');

        $html .= sprintf(
            '<link rel="stylesheet" type="text/css" href="%s?m='.$m.'&%s">' . "\n",
            $this->url->route('debugbar.assets.css'), '/', $time
        );

        $html .= sprintf(
            '<script type="text/javascript" src="%s?m='.$m.'&%s"></script>' . "\n",
            $this->url->route('debugbar.assets.js'), '/', $time
        );

        if ($this->isJqueryNoConflictEnabled()) {
            $html .= '<script type="text/javascript">jQuery.noConflict(true);</script>' . "\n";
        }

        return $html;
    }
}
