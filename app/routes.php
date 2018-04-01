<?php

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use budget\Domain\CategorieTransaction;
use budget\Domain\Transaction;
use budget\Domain\CategorieCompte;
use budget\Domain\Visiteur;
use budget\Domain\Compte;
use budget\Domain\Dictionnary;
use budget\Form\Type\CommentType;
use budget\Form\Type\UserType;
use budget\Form\Type\ProfilType;

// Page d'accueil
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
})->bind('home');

// Login form
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');

// Affichage de tous les comptes
$app->get('/comptes/', function() use ($app) {
    $comptes = $app['dao.compte']->findAllComptes($_SESSION['visiteur']->getId());
    $cats = $app['dao.CategorieCompte']->findAllCategoriesComptes();
    //var_dump($_SESSION['visiteur']->getId());
    return $app['twig']->render('comptes.html.twig', array('comptes' => $comptes, 'categoriesComptes'=> $cats));
})->bind('comptes');

// Affichage de tous les transactions
$app->get('/transactions/', function() use ($app) {
    $transactions = $app['dao.transaction']->findAllTransactions($_SESSION['visiteur']->getId());
    $comptes = $app['dao.compte']->findAllComptes($_SESSION['visiteur']->getId());
    $cats = $app['dao.categorieTransaction']->findAllCategoriesTransactions();
    return $app['twig']->render('transactions.html.twig', array('transactions' => $transactions, 'comptes'=>$comptes, 'categoriesTransactions'=>$cats));
})->bind('transactions');

$app->match('/enregistrement_compte/', function(Request $request) use ($app) {
    //récupération information via post
    $libelle = $_POST['libelle'];
    $montant = $_POST['montant'];
    $idCategorieCompte = $_POST['categorieCompte'];
    $idUser = $_SESSION['visiteur']->getId();;
    
    //sauvegarde dans la bdd
    $app['dao.compte']->saveCompte($idCategorieCompte, $idUser, $libelle, $montant);
    $app['session']->getFlashBag()->add('success', 'probléme enregistré avec succés.');  
    
    //retourner au controleur
    $comptes = $app['dao.compte']->findAllComptes($_SESSION['visiteur']->getId());
    $cats = $app['dao.CategorieCompte']->findAllCategoriesComptes();
    return $app['twig']->render('comptes.html.twig', array('comptes' => $comptes, 'categoriesComptes'=> $cats));
})->bind('add_compte');

$app->get('/compteTransaction/', function() use ($app) {
    $categoriesComptes = $app['dao.CategorieCompte']->findAllCategoriesComptes();
    $categoriesTransactions = $app['dao.categorieTransaction']->findAllCategoriesTransactions();
    return $app['twig']->render('compteTransaction.html.twig', array('categoriesComptes' => $categoriesComptes, 'categoriesTransactions' => $categoriesTransactions));
})->bind('compteTransaction');

$app->match('/saveCompteTransaction/', function(Request $request) use ($app) {
    //récupération information via post
    $libelle = $_POST['libelleCategorieCompte'];
    
    //sauvegarde dans la bdd
    $app['dao.CategorieCompte']->saveCategorieCompte($libelle);
    $app['session']->getFlashBag()->add('success', 'probléme enregistré avec succés.');  
    
    //retourner au controleur
    $categoriesComptes = $app['dao.CategorieCompte']->findAllCategoriesComptes();
    $categoriesTransactions = $app['dao.categorieTransaction']->findAllCategoriesTransactions();
    return $app['twig']->render('compteTransaction.html.twig', array('categoriesComptes' => $categoriesComptes, 'categoriesTransactions' => $categoriesTransactions));
})->bind('add_categorie_compte');

$app->match('/saveTransactionCompte/', function(Request $request) use ($app) {
    //récupération information via post
    $libelle = $_POST['libelleCategorieTransaction'];
    
    //sauvegarde dans la bdd
    $app['dao.categorieTransaction']->saveCategorieTransaction($libelle);
    $app['session']->getFlashBag()->add('success', 'probléme enregistré avec succés.');  
    
    //retourner au controleur
    $categoriesComptes = $app['dao.CategorieCompte']->findAllCategoriesComptes();
    $categoriesTransactions = $app['dao.categorieTransaction']->findAllCategoriesTransactions();
    return $app['twig']->render('compteTransaction.html.twig', array('categoriesComptes' => $categoriesComptes, 'categoriesTransactions' => $categoriesTransactions));
})->bind('add_categorie_transaction');

$app->match('/enregistrement_transaction/', function(Request $request) use ($app) {
    //récupération information via post
    $libelle = $_POST['libelle'];
    $montant = $_POST['montant'];
    $idCategorieTransaction = $_POST['categorieTransaction'];
    $idUser = $_SESSION['visiteur']->getId();
    $idCompteCredit = $_POST["compteCredit"];
    $idCompteDebit = $_POST["compteDebit"];
    //$date = $_POST["dateTransaction"];
    
    //sauvegarde dans la bdd
    $app['dao.transaction']->saveTransaction($idCategorieTransaction, $idCompteCredit, $idCompteDebit, $idUser, $libelle, $montant);
    $app['session']->getFlashBag()->add('success', 'probléme enregistré avec succés.');  
    
    //Modification montant des compte
    $compteCredit = $app['dao.compte']->find($idCompteCredit);
    $compteDebit = $app['dao.compte']->find($idCompteDebit);
    $montantCredit = $compteCredit->getMontantCompte();
    $montantDebit = $compteDebit->getMontantCompte();
    $app['dao.compte']->modificationMontantCompte($idCompteCredit, $compteCredit->getMontantCompte() + $montant);
    $app['dao.compte']->modificationMontantCompte($idCompteDebit, $compteDebit->getMontantCompte() - $montant);

    //retourner au controleur
    $transactions = $app['dao.transaction']->findAllTransactions($_SESSION['visiteur']->getId());
    $comptes = $app['dao.compte']->findAllComptes($_SESSION['visiteur']->getId());
    $cats = $app['dao.categorieTransaction']->findAllCategoriesTransactions();
    return $app['twig']->render('transactions.html.twig', array('transactions' => $transactions, 'comptes'=>$comptes, 'categoriesTransactions'=>$cats));
})->bind('add_transaction');


$app->match('/deleteCategorieCompte/{idCategorieCompte}', function(Request $request, $idCategorieCompte) use ($app) {
    
    $app['dao.CategorieCompte']->DeleteCategorieCompte($idCategorieCompte);
    $app['dao.compte']->modificationCategorieCompte($idCategorieCompte, 1);
    $comptes = $app['dao.compte']->findAllComptes($_SESSION['visiteur']->getId());
    $cats = $app['dao.CategorieCompte']->findAllCategoriesComptes();
    //var_dump($_SESSION['visiteur']->getId());
    return $app->redirect($app["url_generator"]->generate('comptes', array('comptes' => $comptes, 'categoriesComptes'=> $cats)));
});


$app->match('/deleteCategorieTransaction/{idCategorieTransaction}', function(Request $request, $idCategorieTransaction) use ($app) {
    
    $app['dao.categorieTransaction']->DeleteCategorieTransaction($idCategorieTransaction);
    $app['dao.transaction']->modificationCategorieTransaction($idCategorieTransaction, 1);
    
    $transactions = $app['dao.transaction']->findAllTransactions($_SESSION['visiteur']->getId());
    $comptes = $app['dao.compte']->findAllComptes($_SESSION['visiteur']->getId());
    $cats = $app['dao.categorieTransaction']->findAllCategoriesTransactions();
    return $app->redirect($app["url_generator"]->generate('transactions', array('transactions' => $transactions, 'comptes'=>$comptes, 'categoriesTransactions'=>$cats)));
});

$app->match('/modifCategorieCompte/{idCategorieCompte}', function(Request $request, $idCategorieCompte) use ($app) {
    
    $libelle = $_POST['libelle'];
    $app['dao.CategorieCompte']->modificationLibelleCategorieCompte($idCategorieCompte, $libelle);
    
    $transactions = $app['dao.transaction']->findAllTransactions($_SESSION['visiteur']->getId());
    $comptes = $app['dao.compte']->findAllComptes($_SESSION['visiteur']->getId());
    $cats = $app['dao.categorieTransaction']->findAllCategoriesTransactions();
    return $app->redirect($app["url_generator"]->generate('transactions', array('transactions' => $transactions, 'comptes'=>$comptes, 'categoriesTransactions'=>$cats)));
});

$app->match('/modifCategorieTransaction/{idCategorieTransaction}', function(Request $request, $idCategorieTransaction) use ($app) {
    
    $libelle = $_POST['libelle'];
    $app['dao.categorieTransaction']->modificationLibelleCategorieTransaction($idCategorieTransaction, $libelle);
    
    $transactions = $app['dao.transaction']->findAllTransactions($_SESSION['visiteur']->getId());
    $comptes = $app['dao.compte']->findAllComptes($_SESSION['visiteur']->getId());
    $cats = $app['dao.categorieTransaction']->findAllCategoriesTransactions();
    return $app->redirect($app["url_generator"]->generate('transactions', array('transactions' => $transactions, 'comptes'=>$comptes, 'categoriesTransactions'=>$cats)));
});


// inscription d'un client 
$app->match('/inscription', function(Request $request) use ($app) {
    $visiteur = new Visiteur();
    $userForm = $app['form.factory']->create(new UserType(), $visiteur);
    $userForm->handleRequest($request);
    if ($userForm->isSubmitted() && $userForm->isValid()) {

    		// génère un salt aléatoirement
       		$salt = substr(md5(time()), 0, 23);
        	$visiteur->setSalt($salt);
        	$plainPassword = $visiteur->getPassword();
        	 // trouve le codeur par defaut
        	$encoder = $app['security.encoder.digest'];
        	// compute the encoded password
        	$password = $encoder->encodePassword($plainPassword, $visiteur->getSalt());
        	$visiteur->setPassword($password); 
        	$app['dao.visiteur']->save($visiteur);
        	$app['session']->getFlashBag()->add('success', 'compte crée avec succés.');   
    }

    return $app['twig']->render('User_Form.html.twig', array(
        'title' => 'Inscription',
        'userForm' => $userForm->createView()));
})->bind('inscription');

$app->get('/transactionParCompte/{idCompte}', function(Request $request, $idCompte) use ($app) {
    $transactions = $app['dao.transaction']->findByCompte($idCompte);
    $compte = $app['dao.compte']->find($idCompte);
    $comptes = $app['dao.compte']->findAllComptes($_SESSION['visiteur']->getId());
    return $app['twig']->render('transactionsParCompte.html.twig', array('transactions' => $transactions, 'compte' => $compte, 'comptes' =>$comptes));
});

$app->get('/transactionsParComptes/', function() use ($app) {
    //$transactions = $app['dao.transaction']->findAllTransactions($_SESSION['visiteur']->getId());
    //$comptes = $app['dao.compte']->findAllComptes($_SESSION['visiteur']->getId());
    //$cats = $app['dao.categorieTransaction']->findAllCategoriesTransactions();
    
    $comptes = $app['dao.compte']->findAllComptes($_SESSION['visiteur']->getId());
    $dictionnaires = array();
    //foreach (array_expression as $value){ /*commandes*/ }
    foreach($comptes as $compte){
        $dictionnaire = new Dictionnary();
        $transactions = $app['dao.transaction']->findByCompteDebit($compte->getId());
        $dictionnaire->setCompte($compte);
        $dictionnaire->setTransactions($transactions);
        $dictionnaires[$compte->getId()] = $dictionnaire;
    }
    
    
    return $app['twig']->render('transactionsParCompte.html.twig', array('dictionnaires' => $dictionnaires));
})->bind('transactionsParCompte');

