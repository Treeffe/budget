<?php

use Symfony\Component\Debug\ErrorHandler;
ErrorHandler::register();
use Symfony\Component\Debug\ExceptionHandler;
ExceptionHandler::register();


// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app['twig'] = $app->share($app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
}));
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => $app->share(function () use ($app) {
                return new budget\DAO\VisiteurDAO($app['db']);
            }),
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    ),
));


$app['dao.visiteur'] = $app->share(function ($app) {
    return new budget\DAO\VisiteurDAO($app['db']);
});

$app['dao.compte'] = $app->share(function ($app) {
    
    $compteDAO = new budget\DAO\CompteDAO($app['db']); 
    $compteDAO->setVisiteurDAO(new budget\DAO\VisiteurDAO($app['db']));
    $compteDAO->setCategorieCompteDAO($app['dao.CategorieCompte']);

    return $compteDAO;
});

$app['dao.transaction'] = $app->share(function ($app) {
    
    $transactionDAO = new budget\DAO\TransactionDAO($app['db']); 
    $transactionDAO->setCompteCreditDAO($app['dao.compte']);
    $transactionDAO->setCompteDebitDAO($app['dao.compte']);
    $transactionDAO->setVisiteurDAO(new budget\DAO\VisiteurDAO($app['db']));
    $transactionDAO->setCategorieTransactionDAO($app['dao.categorieTransaction']);
    
    return $transactionDAO;
});

$app['dao.CategorieCompte'] = $app->share(function ($app) {
    return new budget\DAO\CategorieCompteDAO($app['db']);
});

$app['dao.categorieTransaction'] = $app->share(function ($app) {
    return new budget\DAO\CategorieTransactionDAO($app['db']);
});

$app['dao.frais'] = $app->share(function ($app) {
    $fraisDAO = new budget\DAO\FraisDAO($app['db']); 
    $fraisDAO->setVisiteurDAO(new budget\DAO\VisiteurDAO($app['db']));
    $fraisDAO->setPeriodeDAO(new budget\DAO\PeriodeDAO($app['db']));
    return $fraisDAO;
});

$app['dao.periode'] = $app->share(function ($app) {
    return new budget\DAO\PeriodeDAO($app['db']);
});