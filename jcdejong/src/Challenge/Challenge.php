<?php

namespace Challenge;

use Doctrine\ORM\ORMException;
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
        $dataFile = __DIR__ . '/../../data/datafile.php';

        if (!file_exists($dataFile)) {
            $config = new LanguageDetector\Config;
            $config->useMb(true);

            $learn = new LanguageDetector\Learn($config);
            foreach (glob(__DIR__ . '/../../samples/learning/*') as $file) {
                $learn->addSample(basename($file), file_get_contents($file));
            }

            $learn->addStepCallback(function ($lang, $status) {
                echo "Learning {$lang}: $status" . PHP_EOL;
            });

            $learn->save(LanguageDetector\AbstractFormat::initFormatByPath($dataFile));
        }

        $detect = LanguageDetector\Detect::initByPath($dataFile);
        $this->language = $detect->detect($string);

        if (is_array($this->language)) {
            $this->language = 'unknown';
        }

        echo 'Language detected: ' . $this->language . PHP_EOL;

        return $this->language;
    }

    /**
     * Load words file into database
     * @todo implement finally
     * @throws ORMException
     */
    public function initWordDb()
    {
        $language = $this->language;
        if ($language == 'unknown') {
            echo 'Unknown language detected, will use English dictionary...' . PHP_EOL;
            $language = 'english';
        }
        $languageFile = __DIR__ . '/../../samples/words/' . $language;

        if (!file_exists($languageFile)) {
            echo 'ERROR - no valid sample words file found for language ' . $language . PHP_EOL;
            die();
        }

        try {
            $counter = 0;
            echo 'Importing ' . $language . ' words into database...';
            $file = fopen($languageFile, 'r');
            while (!feof($file)) {
                $wordRead = trim(fgets($file));

                // only alpha characters (incl. UTF-8 letters), minimum length of 3 and not the same character
                if (preg_replace('/[^\w\p{L}\p{N}\p{Pd}]/u', '', $wordRead, -1) == $wordRead && mb_strlen($wordRead) >= 3 && mb_substr_count($wordRead, $wordRead{0}) != 3) {

                    // stop importing if the word is already in the database (quick'n dirty ftw)
                    if ($counter == 0) {
                        $word = $this->em->getRepository('Entities\Word')->findOneBy(array('word' => $wordRead, 'language' => $language));
                        if ($word) {
                            echo ' skipped, ' . $language . ' records are already in the database.' . PHP_EOL;
                            return;
                        }
                    }

                    // save the word to database
                    $word = new Word();
                    $word->setWord($wordRead);
                    $word->setLanguage($language);
                    $this->em->persist($word);
                    $counter++;
                }

                if ($counter % 10000 == 0) {
                    echo '.';
                    $this->em->flush();
                }
            }
            echo 'done' . PHP_EOL;
        } catch (ORMException $e) {
            echo 'An error occurred while inserting words into database... (this may take a while, depending on the amount of words)' . PHP_EOL;
            echo $e->getMessage() . PHP_EOL;
            die();
        } finally {
            fclose($file);
        }
        $this->em->flush();
    }
}