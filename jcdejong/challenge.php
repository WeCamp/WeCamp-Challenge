<?php

require_once __DIR__ . '/vendor/autoload.php';

// it could use a little bit of memory, but it's fine because this process runs once.
ini_set('memory_limit', '1G');
mb_internal_encoding('UTF-8');

// we load the configuration (which will be serialized later into our language model file
$config = new LanguageDetector\Config;
$config->useMb(true);

$c = new LanguageDetector\Learn($config);
foreach (glob(__DIR__ . '/samples/*') as $file) {
    // feed with examples ('language', 'text');
    $c->addSample(basename($file), file_get_contents($file));
}

// some callback so we know where the process is
$c->addStepCallback(function($lang, $status) {
    echo "Learning {$lang}: $status\n";
});

// save it in `datafile`.
$c->save(LanguageDetector\AbstractFormat::initFormatByPath(__DIR__ . '/data/datafile.php'));

// we load the language model, it would create the $config object for us.
$detect = LanguageDetector\Detect::initByPath(__DIR__ . '/data/datafile.php');

// input some string
$lang = $detect->detect("My brain is a beautiful thing, and I intend to use it at WeCamp");

var_dump($lang);