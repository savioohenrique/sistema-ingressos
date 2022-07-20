<?php

require_once __DIR__ . '/vendor/autoload.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createApplication(
     \App\Infra\EntitymanagerCreator::getEntityManager()
);
