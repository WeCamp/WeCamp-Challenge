<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . '/../vendor/autoload.php';

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$dbConfig = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src/Entities"), $isDevMode);
$dbConnection = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/../data/words.sqlite',
);

// Obtaining the entity manager
$entityManager = EntityManager::create($dbConnection, $dbConfig);