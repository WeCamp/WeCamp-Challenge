<?php

require_once __DIR__ . '/vendor/autoload.php';

// it could use a little bit of memory, but it's fine because this process runs once.
ini_set('memory_limit', '1G');
mb_internal_encoding('UTF-8');

$string = '';
//$string = "My brain is a beautiful thing, and I intend to use it at WeCamp";
if (isset($argv[1]) && trim($argv[1]) != '') {
    $string = $argv[1];
}

if ($string == '') {
    echo 'usage: ' . basename(__FILE__) . ' "your input string"'. PHP_EOL;
    die();
}

$challenge = new Challenge\Challenge();
$language = $challenge->determineLanguage($string);
var_dump($language);