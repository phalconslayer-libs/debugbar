# Phalcon Slayer Libraries, presents "Debug Bar"

This library contains a service provider for Phalcon Slayer.


## Installation


### first step
```
composer require phalconslayer-libs/debugbar
```

### second step

Go to your `config/app.php` and under the `services`, you must add the service provider.

```
// config.php

'services' => [
    ...
    PhalconslayerLibs\Debugbar\DebugbarServiceProvider::class,
],
```

### third step

publish the config using `brood` command using terminal / iterm, etc.

```
$ php brood vendor:publish debugbar
$ Are you sure you want to publish 'config'? [y/n]: y
```
