<?php

namespace App\Controllers;

use App\Models\AppUser;




// Si j'ai besoin du Model Category
// use App\Models\Category;

class UserController extends CoreController
{
    public function edit($params, $validate=false)
    {
        
        

        $userModel = new AppUser;
        $user = $userModel->find($params);

        $data = [
            'user' => $user,
            'validate' => $validate
        ];

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('user/user_edit', $data);
    }

    public function list()
    {
         // la je verifie
        //  $this->checkAuthorization( ['admin', 'superadmin' ] );
        
        $usersModel = new AppUser;
        $users = $usersModel->findAll();

        $data = [
            'users' => $users,
        ];


        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('user/user', $data);
    }

    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function add()
    {

        // la je verifie
        // $this->checkAuthorization( [ 'admin', 'superadmin' ] );
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('user/user_add');
    }

    /**
     * Méthode s'occupant de creer une categorie dans la bdd
     *
     * @return void
     */
    public function create()
    {
        // la je verifie
        $this->checkAuthorization( [ 'admin', 'superadmin' ] );

        $email = filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL );
        $password_not_empty = (strlen($_POST['password']) > 0);
        $password = filter_input(INPUT_POST, 'password');
        $password_confirm = filter_input(INPUT_POST, 'password_confirm');
        
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        //on crée un tableau vide pour ajouter toutes les erreurs rencontrées:
        $errorsList = [];

        if (empty($email) || $email === false) {
            $errorsList[] = "L'email n'est pas valide !";
        }
        // peut importe si la premiere à réussi on fait 'autres test à part:
        if (empty($password) || $password === false) {
            $errorsList[] = "Le password est invalide !";
        }
        if ($password !== $password_confirm) {
            $errorsList[] = "Les deux mots de passe sont différents !";
        }
        if (empty($firstname) || $firstname === false) {
            $errorsList[] = "Le Nom est invalide!";
        }
        if (empty($lastname) || $lastname === false) {
            $errorsList[] = "Le Prénom est invalide!";
        }
        if (empty($role) || $role === false) {
            $errorsList[] = "Le Rôle est invalide!";
        }
        
        if ( $status === false) {
            $errorsList[] = "Le Statut est invalide!";
        }
        
        
        // si errorlist est vide tout ok on peut ajouter en bdd
        if (empty($errorsList)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $user = new AppUser;
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setRole($role);
            $user->setStatus($status);
            
           $insertIsInsert = $user->insert();

           if($insertIsInsert) {
               // redirection vers la liste des categories
               // attention cela fonctionne si serveur de test.
               // il vaut mieux utiliser generate du coup?
               // a condition que global $router ne soit pas dans le show car sinon
               // pas acces à cet endroit
               // header("Location: ".$router->generate('etiquette));
               // a condition d'avoir acces à $router, donc pas uniuquement dans show!!!!
               
               header("Location: /users");
               // important dee s'assurer que la suite du code n'est pas effectué car la redisrection ne coupe pas la suite du code en attendant la redirection.
               exit();

           } else {
               $errorsList[] = "une erreur est survenue lors de l'ajout de l'utilisateur";
               dump($errorsList);
           }
           
        }
        // si un champs n'est pas rempli par exemple.
        // dump( $errorsList );
        dump($errorsList);
        // vérifier si toutes les données existent avant d'insérer dans la base de donnée
        // TODO afficher une erreur sur le formulaire
        // if ($name & $subtitle & $picture & $home_order) {
        //     $category = new Category;
        //     $category->setName($name);
        //     $category->setSubtitle($subtitle);
        //     $category->setPicture($picture);
        //     $category->setHomeOrder($home_order);
    
        //     $category->insert();
        // }
        

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        // $this->list();
    }

    public function login()
    {
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/connexion');
    }

    public function logout()
    {
        // pour deconnecter l'utilisateur plusieurs solutiosn:
        $_SESSION = [];

        // a changer
        global $router;
        header('Location: '. '/');
        exit;
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

        // TODO rajouter la condition si on ne recupere pas d'ŝuer
        // et/oui que le $-SESSIOn ne contient personne
        if(password_verify($_POST['password'], $user->getPassword())) {
            
            $_SESSION['userObject'] = $user;
            $_SESSION['userId'] = $user->getId();
        } else { 
            $errorsList[] = "Le mot de passe ou le login ne correspondent pas !";
            unset($_SESSION['userObject']);
            unset($_SESSION['userId']);
        }

        // peut importe si la premiere à réussi on fait 'autres test à part:
    //     if ($user == false)  { 
    //         $errorsList[] = "Le mot de passe ou le login ne correspondent pas !";
    //         unset($_SESSION['userObject']);
    //         unset($_SESSION['userId']);
    //     } else {
    //         $_SESSION['userObject'] = $user;
    //         $_SESSION['userId'] = $user->getId(); 
    // }   
        

        



        // a changer
        global $router;
        header('Location: '. $router->generate('main-home'));
        exit;
    }

}
