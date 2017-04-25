<?php

use Clarity\Facades\Route;

$namespace = config('debugbar.routing.namespace', 'Snowair\Debugbar\Controllers');

Route::add('/_debugbar/open', array(
    'namespace' => $namespace,
    'controller' => config('debugbar.routing.open.controller', 'OpenHandler'),
    'action' => config('debugbar.routing.open.action', 'handleAction'),
))->setName('debugbar.openhandler');

Route::add('/_debugbar/assets/stylesheets', array(
    'namespace' => $namespace,
    'controller' => config('debugbar.routing.css.controller', 'Asset'),
    'action' => config('debugbar.routing.css.action', 'cssAction'),
))->setName('debugbar.assets.css');

Route::add('/_debugbar/assets/javascript', array(
    'namespace' => $namespace,
    'controller' => config('debugbar.routing.js.controller', 'Asset'),
    'action' => config('debugbar.routing.js.action', 'jsAction'),
))->setName('debugbar.assets.js');
