<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->pluginsDir,
        $config->application->customhelpersDir
    ]
);

/**
 * Register composer autoloader
 */
$loader->registerFiles(
    [
        BASE_PATH . '/vendor/autoload.php'
    ]
);

/**
 * Register loader
 */
$loader->register();
