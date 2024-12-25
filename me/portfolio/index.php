<?php

if (is_file(__DIR__ . '/vendor/autoload.php')) {
    require_once(__DIR__ . '/vendor/autoload.php');
} else {
    die("Cannot find 'vendor/autoload.php'. Run `composer install`.");
}

require_once(__DIR__ . "/config/config.php");

// instance Pico
$pico = new Pico(
    __DIR__,    // root dir
    'config/',  // config dir
    'plugins/', // plugins dir
    'themes/'   // themes dir
);

// override configuration?
//$pico->setConfig(array());

$request_uri = $_SERVER['REQUEST_URI'];

if (strpos($request_uri, 'css.md') !== false) {
    // Parse the Markdown file
    $parsedown = new Parsedown();
    $markdownContent = file_get_contents(__DIR__ . '/css.md');
    $htmlContent = $parsedown->text($markdownContent);  // Converts Markdown to HTML
    
    // Pass this HTML content to your Pico theme
    // You can do this by setting it in the Pico environment or directly rendering the content
    // Example (if you're passing it to the template engine):
    $pico->set('content', $htmlContent);
}

$pico->setConfig(array(
    'session' => $_SESSION
));

// run application
echo $pico->run();
