<?php

$included = false;

foreach (array(__DIR__ . '/../../autoload.php', __DIR__ . '/../vendor/autoload.php', __DIR__ . '/vendor/autoload.php') as $file) {
    if (file_exists($file)) {
        include $file;
        $included = true;
        break;
    }
}

if (!$included) {
    fwrite(STDERR,
        'You need to set up the project dependencies using the following commands:' . PHP_EOL .
        'wget http://getcomposer.org/composer.phar' . PHP_EOL .
        'php composer.phar install' . PHP_EOL
    );
    die(1);
}

$app = new \Symfony\Component\Console\Application();
$app->add(new \SlayerBirden\Command\GenerateCreateCommand());
$app->run();
