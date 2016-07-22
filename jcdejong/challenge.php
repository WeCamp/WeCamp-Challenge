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
echo PHP_EOL . $output . PHP_EOL . str_repeat('-', mb_strlen($output)) . PHP_EOL;

// @todo add images using a google/flickr search, prettify, test, etc ;)
$words = explode(' ', $string);
$output = [];
foreach ($words as $word) {
    $rebus = new Challenge\Rebus($word, $language, $entityManager);
    ob_start();
    $rebus->dump();
    $output[] = explode(PHP_EOL, ob_get_clean());
}

//vertical dump rebus
if (isset($argv[2]) && mb_strpos($argv[2], 'vertical') !== false) {
    foreach ($output as $rebus) {
        echo implode(PHP_EOL, $rebus);
        echo '----------------------------' . PHP_EOL;
    }
} else {
    // horizontal dump :)
    $colSize = [];
    echo '|';
    foreach ($output as $key => $word) {
        if (isset($word[0])) {
            echo str_pad($word[0], mb_strlen($word[0]) + 5, ' ', STR_PAD_BOTH) . '|';

            $colSize[$key] = mb_strlen($word[0]) + 5;
        }
    }
    echo PHP_EOL . '|';
    foreach ($output as $key => $word) {
        if (isset($word[1])) {
            echo str_pad($word[1], $colSize[$key], ' ', STR_PAD_BOTH) . '|';
        }
    }
    echo PHP_EOL . '|';
    foreach ($output as $key => $word) {
        if (isset($word[2])) {
            echo str_pad($word[2], $colSize[$key], ' ', STR_PAD_BOTH) . '|';
        }
    }
    echo PHP_EOL;
}