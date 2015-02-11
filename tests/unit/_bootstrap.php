<?php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../public/bootstrap.php";

\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
    "Symfony\\Component\\Validator\\Constraint",
    __DIR__ . "/../../vendor/symfony/validator"
);
// Here you can initialize variables that will be available to your tests
