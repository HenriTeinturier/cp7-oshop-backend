<?php

namespace App\Controllers;


abstract class CoreController
{
    
    public $router;
    // le constructeur de CoreController sera utilisé par tous ses enfants.
    public function __construct($router, $match) {
        // Récupérer le nom de la route courante (etiquette = nom)
        
        


        $currentRouteName = $match['name'] ;
        $this->router = $router;
        // definir une liste de permission pour chaque route
        // uniquement cell necessitant d'être connecté
        // acces coontrol list:
        // pas besoin de reference la page sans besoin detre connecter: la page login.
        // même la page d'accueil devrait ^etre avec au moins catalog...
        $acl = [
            "user-add" => ["admin"],
            "user-create" => ["admin"],
            "user-edit" => ["admin"],
            "user-update" => ["admin"],
            "user-list" => ["admin"],
            "user-delete" => ["admin"],
            

            'main-home' => ["admin", "catalog-manager"],

            'category-list' => ["admin", "catalog-manager"],
            'category-delete' => ["admin", "catalog-manager"],
            'category-add' => ["admin", "catalog-manager"],
            'category-create' => ["admin", "catalog-manager"],
            'category-mod' => ["admin", "catalog-manager"],
            'category-modCalid' => ["admin", "catalog-manager"],

            'product-list' => ["admin", "catalog-manager"],
            'product-delete' => ["admin", "catalog-manager"],
            'product-add' => ["admin", "catalog-manager"],
            'product-create' => ["admin", "catalog-manager"],
            'product-mod' => ["admin", "catalog-manager"],
            'product-modValid' => ["admin", "catalog-manager"],





        ];

        // vérifier si la route actuelle est dans la liste
        if(array_key_exists($currentRouteName, $acl)) {
            // si cest le cas vérifier que l'user est coneecté et que
            // son role correspond

            //on recupere role authorisé à utiliser la route actuelle
            $authorizeRolesForCurrentRoute = $acl[$currentRouteName];
            // on verifie si l'user à les droits avec checkAuthorization:
            $this->checkAuthorization($authorizeRolesForCurrentRoute);

            //checekauthorization s'occupera de rediriger l'utilisateur si necessaire.

            // sinon rediriger vers page connexion


        }

            // sinon laisser la page s executer normalement

        // token anti-CRSF

        // 1er liste des routes en POST pour lesquels il faut vérifier le token

        $crsfTokenCheckPost = [
            "user-create",
            "user-connect",
            "user-update",
            "category-create",
            "category-modCalid",
            "category-update",
            "product-create",
            "product-modValid",
            "main-homepageValid"
            // ...
        ];

        // la même chose pour les routes en GET tout ce qui est en POST:
        $crsfTokenCheckGet = [
            "user-add",
            "user-delete",
            "category-add",
            "category-delete",
            "main-homepage",
            "product-add",
            // "user-login",
            // ...
        ];

        // si la route actuelle necessite une verification de token
        if (in_array($currentRouteName, $crsfTokenCheckPost)){
            // on recupere le token en post s'il existe si nous naviguions sur notre site
            $token = $_POST['token'] ?? "";

            // je récupère le token stocke en session:
            $sessionToken = $_SESSION['token'] ?? "";

            if($token !== $sessionToken || empty($token)) {
                // todo erreur 403
                echo 'erreur 403';
            } else {
                // sinon tout va bien
                // on en profite pour retirer le token de session
                // empeche de valider 2* le meme formulaire
                unset($_SESSION['token']);
            }

        }
        // faire les verifs avec GET
        // une fois les vérifications faites on peut generer un token pour la nouvelle page
        //
        //pour bien comprendre on ajoute le nom de la route actuelle à chaque token
        // permet de generer un token sur chaque page ou l'on se trouve. de remettre à jour le token en permanence à chaque changement de page.
        $_SESSION['token'] = $currentRouteName."_".bin2hex(random_bytes(16));


    }

    
    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {
        // On globalise $router car on ne sait pas faire mieux pour l'instant
        global $router;

        // Comme $viewData est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        // ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()
        $viewData['currentPage'] = $viewName;

        // définir l'url absolue pour nos assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // On veut désormais accéder aux données de $viewData, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewData);
        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        // $viewData est disponible dans chaque fichier de vue
        dump($_SESSION);

        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }

    /**
     * Methode s'occupant de gérer les vérifs de rôle pour chaque page
     *
     * @return void
     */
    protected function checkAuthorization($authorizedRoles = []) {
        //verifier si l'utilisateur est connecté
        if (isset($_SESSION['userObject'])):
            // si connecte on recuper l'user et donc son rôle
            $currentUserRole = $_SESSION['userObject']->getRole();
            // verifier si le rôle est autoriséé à acceder à la page
            // cela revient à verfier si le rôle est dans le tableau $authoriseRoles
                
                // si oui alors j'ai le droit d'acceder à la pager on return true
                if (in_array($currentUserRole, $authorizedRoles)):
                    return true;
                // sinon on envoi le header 403 forbidden on arrête le  script et on affiche l'erreur
                else:
                   http_response_code(403);
                // on affiche l'erreur
                $this->show( "main/erreur403" );

                //on arrêt le script sinon la page demandé va s'afficher
                exit();
                endif;


        // sinon, on l'envoi vers la page de ocnnexion
        else:
            header("Location: /login"); //serait mieux avec router-Wgenerate() mais il faut rendre router accessible avec construct
            exit();  
             

        endif;


    }
}
