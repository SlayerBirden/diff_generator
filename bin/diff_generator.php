<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$app = new \Symfony\Component\Console\Application();
$app->add(new \SlayerBirden\Command\GenerateCreateCommand());
$app->run();
