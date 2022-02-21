<?php

namespace App\Controllers;

abstract class CoreController
{
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
