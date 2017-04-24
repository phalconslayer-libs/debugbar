<?php

use Clarity\Facades\Route;

Route::add('/_debugbar/open', array(
    'namespace' => 'Snowair\Debugbar\Controllers',
    'controller' => 'OpenHandlerController',
    'action' => 'handleAction',
))->setName('debugbar.openhandler');

Route::add('/_debugbar/assets/stylesheets', array(
    'namespace' => 'Snowair\Debugbar\Controllers',
    'controller' => 'AssetController',
    'action' => 'cssAction',
))->setName('debugbar.assets.css');

Route::add('/_debugbar/assets/javascript', array(
    'namespace' => 'Snowair\Debugbar\Controllers',
    'controller' => 'AssetController',
    'action' => 'jsAction',
))->setName('debugbar.assets.js');
