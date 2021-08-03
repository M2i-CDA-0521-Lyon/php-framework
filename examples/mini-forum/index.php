<?php

use Cda0521Framework\Application;

// Active le chargement automatique des classes dans le projet
require_once __DIR__ . '/vendor/autoload.php';

$application = new Application();
$application->run();
