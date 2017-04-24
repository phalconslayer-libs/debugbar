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

And you are done!

# How to contribute?

Fork this into your github account, go to your phalcon slayer project at `sandbox` folder.

Then clone `git clone https://github.com/phalconslayer-libs/debugbar.git phalconslayer-libs/debugbar`

In your slayer base `composer.json`, add

```
    "require": {
        "phalconslayer-libs/debugbar": "*"
    },
    "repositories": {
        "phalconslayer-libs/debugbar": {
            "type": "path",
            "url": "phalconslayer-libs/debugbar"
        }
    }
```

Then run `composer update`, if you are using windows, you always need to run this since composer will copy the folder under the `vendor`, if your operating system supports symlink, then that would really help, there are lots of `vcs` options in composer, so try to explore more about it.
