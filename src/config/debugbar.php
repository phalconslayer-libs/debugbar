<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Debugbar Settings
     |--------------------------------------------------------------------------
     |
     | Debugbar is enabled by default, when debug is set to true in app.php.
     |
     */
    'enabled' => true,


    /*
     |--------------------------------------------------------------------------
     | Routing Settings
     |--------------------------------------------------------------------------
     |
     | Change the route configurations.
     |
     */
    'routing' => [
        'namespace' => 'Snowair\Debugbar\Controllers',

        'open' => [
            'controller' => 'OpenHandlerController',
            'action' => 'handleAction',
        ],

        'css' => [
            'controller' => 'AssetController',
            'action' => 'cssAction',
        ],

        'js' => [
            'controller' => 'AssetController',
            'action' => 'jsAction',
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Storage settings
     |--------------------------------------------------------------------------
     |
     | 'file' driver is the only supported now.
     |
     */
    'storage' =>  [
        'enabled' => true,
        # file, mongodb, elastic
        'driver' => 'file',
        # for file driver
        'path' => '../storage/slayer/debugbar',
        # mongodb driver
        'mongodb' =>  [
                             'connection' => 'mongodb://localhost:27017',
                             'db'=>'debugbar',
                             'collection' => 'debugbar',
                             'options'=> [],
        ],
        # elasticsearch driver
        'elastic' => [
             'hosts' => ['localhost:9200'],
             'index' =>'debugbar',
             'type' => 'debugbar',
             'connection_params' => [],
             'ssl' => [
                 'key' => '',
                 'cert' => '',
                 'verify' => '',
             ],
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Safe check: White Lists settings
     | check order: white_list, allow_routes, deny_routes
     |--------------------------------------------------------------------------
     |
     | the values are clients IPs, if allow all ips, leave  a empty array.
     |
     */
    'white_lists'=> [
        // '127.0.0.1',
    ],

    /*
     |--------------------------------------------------------------------------
     | Safe check: Allowed Users settings
     |--------------------------------------------------------------------------
     |
     | the values are user names.
     |
     */
    'allow_users'=> [],

    /*
     |--------------------------------------------------------------------------
     | Safe check: Allowed Routes settings
     |--------------------------------------------------------------------------
     |
     | the values are route names.
     |
     */
    'allow_routes'=> [],

    /*
     |--------------------------------------------------------------------------
     | Safe check: Exclude Routes settings
     |--------------------------------------------------------------------------
     |
     | the values are route names.
     |
     */
    'deny_routes' => [],


    /*
     |--------------------------------------------------------------------------
     | Vendors
     |--------------------------------------------------------------------------
     |
     | Vendor files are included by default, but can be set to false.
     | This can also be set to 'js' or 'css', to only include javascript or css vendor files.
     | Vendor files are for css: font-awesome (including fonts) and highlight.js (css files)
     | and for js: jquery and and highlight.js
     | So if you want syntax highlighting, set it to true.
     | jQuery is set to not conflict with existing jQuery scripts.
     |
     */

    'include_vendors' => true,

    /*
     |--------------------------------------------------------------------------
     | Capture Ajax Requests
     |--------------------------------------------------------------------------
     |
     | The Debugbar can capture Ajax requests and display them. If you don't want this (ie. because of errors],
     | you can use this option to disable sending the data through the headers.
     |
     */

    'capture_ajax' => true,

    /*
     |--------------------------------------------------------------------------
     | DataCollectors
     |--------------------------------------------------------------------------
     |
     | Enable/disable DataCollectors
     |
     */

    'collectors' =>  [
        'memory'          => true,  // Memory usage
        'exceptions'      => true,  // Exception displayer
        'default_request' => false, // Regular or special Symfony request logger
        'phalcon_request' => true,  // Only one can be enabled..
        'session'         => false,  // Display session data in a separate tab
        'config'          => false, // Display the config service content
        'route'           => false, // Display the current route infomations.
        'log'             => false, // Display messages of the log service sent.
        'db'              => false, // Display the sql statments infomations. Just for Phalcon ORM. 'db' and 'doctrine', you only can choose one!
        'doctrine'        => false, // Display the sql statments infomations. Just for Doctrine ORM.'db' and 'doctrine', you only can choose one!
        'view'            => false, // Display the rendered views infomations.
        'cache'           => false, // Display the cache operation infomations.
        'mail'            => false,
    ],

    /*
     |--------------------------------------------------------------------------
     | Extra options
     |--------------------------------------------------------------------------
     |
     | Configure some DataCollectors
     |
     */
    'options' => [
        'exceptions' => [
            'chain' => true,
        ],
        'db' =>  [
            'with_params' => false,   // Render SQL with the parameters substituted
            'backtrace' => false,  // EXPERIMENTAL: Use a backtrace to find the origin of the query in your files.
            'explain' => false,  // EXPLAIN select statement
            'error_mode' => \PDO::ERRMODE_EXCEPTION, // \PDO::ERRMODE_SILENT , \PDO::ERRMODE_WARNING, \PDO::ERRMODE_EXCEPTION
            'show_conn' =>false, // IF show connection info
        ],
        'mail' =>  [
            'full_log' => false
        ],
        'views' =>  [
            'data' => false,    //Note: Can slow down the application, because the data can be quite large..
        ],
        'config' =>  [
            'protect'=> [
                'database.password', // 在debugbar中以******显示的敏感内容, 最多支持使用两次.号
            ],
        ],
        'log' => [
            'aggregate'=>false,  // Set to True will aggregate logs to MessagesCollector
            'formatter'=>'line', // line , syslog or a class implenment \Phalcon\Logger\FormatterInterface
        ],
        'cache' => [
            'mode'=>1, // 0: only count and aggregate summary to MessagesCollector; 1: show detail on CacheCollector
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Inject Debugbar in Response
     |--------------------------------------------------------------------------
     |
     | Usually, the debugbar is added just before <body>, by listening to the
     | Response after the App is done. If you disable this, you have to add them
     | in your template yourself. See http://phpdebugbar.com/docs/rendering.html
     |
     */
    'inject' => true,

    /*
     * Warning: You must disable open handler for production environment.
     */
    'open_handler'=> [
        'enable' => true,
    ],
];
