<?php

require_once __DIR__ . '/vendor/autoload.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createApplication(
    (new \App\Infra\EntitymanagerCreator())->getEntityManager()
);