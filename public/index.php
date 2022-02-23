<?php

// POINT D'ENTRÉE UNIQUE :
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
require_once '../vendor/autoload.php';

session_start();





/* ------------
--- ROUTAGE ---
-------------*/

// On démarre le système de gestion des sessions de PHP
// session_start();

// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else { // sinon
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter,
// afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : informations contenant
//      - le nom de la méthode à utiliser pour répondre à cette route
//      - le nom du controller contenant la méthode
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"

$router->map(
    'GET','/', '\App\Controllers\MainController@home','main-home'
);

$router->map(
    'GET','/', '\App\Controllers\MainController@erreur403','main-erreur403'
);

$router->map(
    'GET','/login', '\App\Controllers\UserController@login','user-login'
);

$router->map(
    'GET','/homepage', '\App\Controllers\MainController@homepage','main-homepage'
);

$router->map(
    'POST','/homepage', '\App\Controllers\MainController@homepageValid','main-homepagevalid'
);

$router->map(
    'POST','/login', '\App\Controllers\UserController@connect','user-connect'
);

$router->map(
    'GET','/logout', '\App\Controllers\UserController@logout','user-logout'
);

$router->map(
    'GET', '/users', '\App\Controllers\UserController::list','user-list'
);

$router->map(
    'GET', '/user-add', '\App\Controllers\UserController@add','user-add'
);
$router->map(
    'POST','/user-add', '\App\Controllers\UserController@create','user-create'
);

// Pas utilisée pour le moment
$router->map(
    'GET',
    '/user_update/[i:id]', '\App\Controllers\UserController::edit','user-edit'
);
// Pas utilisée pour le moment
$router->map(
    'POST','/user_update/[i:id]', '\App\Controllers\UserController@update','user-update'
);
// Pas utilisée pour le moment
$router->map(
    'GET', '/user_delete/[i:id]',  '\App\Controllers\UserController::deleteUser','user-delete'
);



$router->map(
    'GET', '/categorie', '\App\Controllers\CategoryController::list','category-list'
);


// a corriger
$router->map(
    'GET', '/delete/[i:id]',  '\App\Controllers\CategoryController::deleteCat','category-delete'
);

$router->map(
    'GET', '/categorie_add', '\App\Controllers\CategoryController@add','category-add'
);
$router->map(
    'POST','/categorie_add', '\App\Controllers\CategoryController@create','category-create'
);

$router->map(
    'GET',
    '/categorie_mod/[i:id]', '\App\Controllers\CategoryController::mod','category-mod'
);

$router->map(
    'POST','/categorie_mod/[i:id]', '\App\Controllers\CategoryController@modValid','category-modCalid'
);



$router->map(
    'GET',
    '/produit',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\ProductController' // On indique le FQCN de la classe
    ],
    'product-list'
);

// a corriger
$router->map(
    'GET', '/deleteProduct/[i:id]',  '\App\Controllers\ProductController::deleteProduct','product-delete'
);

$router->map(
    'GET',
    '/produit_add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\ProductController' // On indique le FQCN de la classe
    ],
    'product-add'
);



$router->map(
    'POST',
    '/produit_add',
    [
        'method' => 'create',
        'controller' => '\App\Controllers\ProductController' // On indique le FQCN de la classe
    ],
    'product-create'
);


$router->map(
    'GET',
    '/produit_mod/[i:id]',
    [
        'method' => 'mod',
        'controller' => '\App\Controllers\ProductController' // On indique le FQCN de la classe
    ],
    'product-mod'
);

$router->map(
    'POST',
    '/produit_mod/[i:id]',
    [
        'method' => 'modValid',
        'controller' => '\App\Controllers\ProductController' // On indique le FQCN de la classe
    ],
    'product-modValid'
);





/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller

// on peut ajouter des arguments dans le $dispatcher: $router, ...)
$dispatcher->setControllersArguments($router, $match);

$dispatcher->dispatch();
