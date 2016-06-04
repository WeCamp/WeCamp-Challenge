<?php

namespace Challenge;

use Entities\Word;
use LanguageDetector;

class Challenge
{
    private $language;

    /** @var \Doctrine\ORM\EntityManager $em */
    private $em;

    /**
     * Challenge constructor.
     * @param \Doctrine\ORM\EntityManager constructor $entityManager
     */
    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Determine the language of a string
     * @todo split code, write tests, skip learning if file already exists, improve ;)
     * @param $string
     * @return string
     * @throws \Exception
     */
    public function determineLanguage($string)
    {
        $config = new LanguageDetector\Config;
        $config->useMb(true);

        $learn = new LanguageDetector\Learn($config);
        foreach (glob(__DIR__ . '/../../samples/learning/*') as $file) {
            $learn->addSample(basename($file), file_get_contents($file));
        }

        $learn->addStepCallback(function($lang, $status) {
            echo "Learning {$lang}: $status" . PHP_EOL;
        });

        $learn->save(LanguageDetector\AbstractFormat::initFormatByPath(__DIR__ . '/../../data/datafile.php'));

        $detect = LanguageDetector\Detect::initByPath(__DIR__ . '/../../data/datafile.php');

        $this->language = $detect->detect($string);

        if (is_array($this->language)) {
            $this->language = 'unknown';
        }

        return $this->language;
    }

    /**
     * Load words file into database
     * @todo implement finally
     * @throws \Doctrine\ORM\ORMException
     */
    public function initWordDb()
    {
        $language = $this->language;
        if ($language == 'unknown') {
            echo 'Unknown language detected, will use English dictionary...' . PHP_EOL;
            $language = 'english';
        }

        try {
            $counter = 0;
            echo 'Importing words into database...' . PHP_EOL;
            $file = fopen(__DIR__ . '/../../samples/words/' . $language, 'r');
            while (!feof($file)) {
                $word = new Word();
                $word->setWord(trim(fgets($file)));
                $this->em->persist($word);

                if ($counter++ % 10000 == 0) {
                    echo '.';
                    $this->em->flush();
                }
            }
            echo PHP_EOL;
        } catch (\Doctrine\ORM\ORMException $e) {
            echo 'An error occurred while inserting words into database... (this may take a while, depending on the amount of words)' . PHP_EOL;
            echo $e->getMessage() . PHP_EOL;
            die();
        } finally {
            fclose($file);
        }
        $this->em->flush();
    }
}