<?php

require 'vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addBodyParsingMiddleware();


require 'src/routes.php';

$app->run();
