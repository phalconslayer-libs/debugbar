<?php

use Clarity\Facades\Route;

$dispatcher = di()->get('dispatcher');

Route::add('/_debugbar/open', array(
    'namespace' => 'Snowair\Debugbar\Controllers',
    'controller' => sprintf('OpenHandler%s', $dispatcher->getControllerSuffix()),
    'action' => sprintf('handle%s', $dispatcher->getActionSuffix()),
))->setName('debugbar.openhandler');

Route::add('/_debugbar/assets/stylesheets', array(
    'namespace' => 'Snowair\Debugbar\Controllers',
    'controller' => sprintf('Asset%s', $dispatcher->getControllerSuffix()),
    'action' => sprintf('css%s', $dispatcher->getActionSuffix()),
))->setName('debugbar.assets.css');

Route::add('/_debugbar/assets/javascript', array(
    'namespace' => 'Snowair\Debugbar\Controllers',
    'controller' => sprintf('Asset%s', $dispatcher->getControllerSuffix()),
    'action' => sprintf('js%s', $dispatcher->getActionSuffix()),
))->setName('debugbar.assets.js');
