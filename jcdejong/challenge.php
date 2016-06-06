<?php

require_once __DIR__ . '/app/bootstrap.php';

// depending on the language samples to process, you might want to increase the memory usage ;)
//ini_set('memory_limit', '1G');
mb_internal_encoding('UTF-8');

$string = '';
$string = "My brain is a beautiful thing, and I intend to use it at WeCamp";
if (isset($argv[1]) && trim($argv[1]) != '') {
    $string = $argv[1];
}

if ($string == '') {
    echo 'usage: ' . basename(__FILE__) . ' "your input string"'. PHP_EOL;
    die();
}

$challenge = new Challenge\Challenge($entityManager);
$language = $challenge->determineLanguage($string);
$challenge->initWordDb();

$output = 'Here is the rebus to solve: ';
echo PHP_EOL . $output . PHP_EOL . str_repeat('-', strlen($output)) . PHP_EOL;

$words = explode(' ', $string);
foreach ($words as $word) {
    $rebus = new Challenge\Rebus($word, $entityManager);
    $rebus->dump();
}