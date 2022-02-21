<?php

namespace App\Controllers;

use App\Models\AppUser;




// Si j'ai besoin du Model Category
// use App\Models\Category;

class UserController extends CoreController
{

    public function login()
    {
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/connexion');
    }

    public function connect()
    {
        
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        // on vérifie seulement qu'il n'est pas vide
        $password_not_empty = (strlen($_POST['password']) > 0);
        $password = filter_input(INPUT_POST, 'password');

        // rechercho ok sinon reçois false
        $user = AppUser::findByEmail($email);
        
        //on crée un tableau vide pour ajouter toutes les erreurs rencontrées:
        $errorsList = [];

        if (empty($email) || $email === false) {
            $errorsList[] = "L'email est invalide !";
        }
        // peut importe si la premiere à réussi on fait 'autres test à part:
        if (empty($password) || $password === false) {
            $errorsList[] = "Le password est invalide !";
        }
        // peut importe si la premiere à réussi on fait 'autres test à part:
        if ( $user === false) {
            $errorsList[] = "L'utilisateur n'existe pas !";
        }
        // peut importe si la premiere à réussi on fait 'autres test à part:
        if ($user == false)  { 
            $errorsList[] = "Le mot de passe ou le login ne correspondent pas !";
            unset($_SESSION['userObject']);
            unset($_SESSION['userId']);
        } else {
            $_SESSION['userObject'] = $user;
            $_SESSION['userId'] = $user->getId(); 
    }   
        

        



        // a changer
        global $router;
        header('Location: '. $router->generate('main-home'));
        exit;
    }

}
