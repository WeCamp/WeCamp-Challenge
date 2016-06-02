<?php

namespace Challenge;

use LanguageDetector;

class Challenge
{
    private $language;

    /**
     * Determine the language of a string
     * @param $string
     * @return string
     * @throws \Exception
     */
    public function determineLanguage($string)
    {
        $config = new LanguageDetector\Config;
        $config->useMb(true);

        $c = new LanguageDetector\Learn($config);
        foreach (glob(__DIR__ . '/../../samples/*') as $file) {
            $c->addSample(basename($file), file_get_contents($file));
        }

        $c->addStepCallback(function($lang, $status) {
            echo "Learning {$lang}: $status" . PHP_EOL;
        });

        $c->save(LanguageDetector\AbstractFormat::initFormatByPath(__DIR__ . '/../../data/datafile.php'));

        $detect = LanguageDetector\Detect::initByPath(__DIR__ . '/../../data/datafile.php');

        $this->language = $detect->detect($string);
        if (is_array($this->language)) {
            $this->language = 'unknown';
        }

        return $this->language;
    }
}