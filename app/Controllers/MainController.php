<?php

namespace App\Controllers;

use App\Models\AppUser;
use App\Models\Product;
use App\Models\Category;

// Si j'ai besoin du Model Category
// use App\Models\Category;

class MainController extends CoreController
{

    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function home()
    {

        $productsModel = new Product;
        $products = $productsModel->findThreeProducts();

        $categoriesModel = new Category;
        $categories = $categoriesModel->findThreeCategories();

        
        $data = [
            'products'=> $products,
            'categories' => $categories,
        ];



        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/home', $data);
    }

    public function connexion()
    {
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/connexion');
    }

    public function connexionValidate()
    {
        dump($_POST);
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

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
        if ( $password != $user->getPassword()) {
            $errorsList[] = "Le mot de passe ou le login ne correspondent pas !";
        }

        




        // $this->show('main/connexion');
    }

}
