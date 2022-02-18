<?php

namespace App\Controllers;

use App\Models\Category;

// Si j'ai besoin du Model Category
// use App\Models\Category;

class CategoryController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function list()
    {
        
        $categoriesModel = new Category;
        $categories = $categoriesModel->findAll();

        $data = [
            'categories' => $categories,
        ];


        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('category/categorie', $data);
    }

    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function add()
    {
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('category/categorie_add');
    }

    /**
     * Méthode s'occupant de creer une categorie dans la bdd
     *
     * @return void
     */
    public function create()
    {

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL);
        $home_order = filter_input(INPUT_POST, 'home_order', FILTER_VALIDATE_INT);

        //on crée un tableau vide pour ajouter toutes les erreurs rencontrées:
        $errorsList = [];

        if (empty($name) || $name === false) {
            $errorsList[] = "Le nom de la catégorie est vide ou invalide !";
        }
        // peut importe si la premiere à réussi on fait 'autres test à part:
        if (empty($subtitle) || $subtitle === false) {
            $errorsList[] = "Le nom du sous titre est vide ou invalide !";
        }
        // peut importe si la premiere à réussi on fait 'autres test à part:
        if ( $picture === false) {
            $errorsList[] = "l'URL de l'image est invalide !";
        }
        // peut importe si la premiere à réussi on fait 'autres test à part:
        if ( empty($home_order) || $home_order === false) {
            $errorsList[] = "home order est soit vide soit pas un nombre entier !";
        }

        // si errorlist est vide tout ok on peut ajouter en bdd
        if (empty($errorsList)) {
            $category = new Category;
            $category->setName($name);
            $category->setSubtitle($subtitle);
            $category->setPicture($picture);
            $category->setHomeOrder($home_order);
    
           $insertIsInsert = $category->insert();

           if($insertIsInsert) {
               // redirection vers la liste des categories
               // attention cela fonctionne si serveur de test.
               // il vaut mieux utiliser generate du coup?
               // a condition que global $router ne soit pas dans le show car sinon
               // pas acces à cet endroit
               // header("Location: ".$router->generate('etiquette));
               // a condition d'avoir acces à $router, donc pas uniuquement dans show!!!!
               echo 'erreur';
               header("Location: /categorie");
               // important dee s'assurer que la suite du code n'est pas effectué car la redisrection ne coupe pas la suite du code en attendant la redirection.
               exit();

           } else {
               $errorsList[] = "une erreur est survenue lors de l'ajout de la catégorie";
               echo 'erreur';
           }
           
        }
        // si un champs n'est pas rempli par exemple.
        dump( $errorsList );

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

    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function mod($params, $validate=false)
    {
        
        

        $categoryModel = new Category;
        $category = $categoryModel->find($params);

        $data = [
            'category' => $category,
            'validate' => $validate
        ];

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('category/categorie_mod', $data);
    }

    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function modValid($id)
    {
        
        
        $name = filter_input(INPUT_POST, 'name');
        $subtitle = filter_input(INPUT_POST, 'subtitle');
        $picture = filter_input(INPUT_POST, 'picture');
        $home_order = filter_input(INPUT_POST, 'home_order');
        
        // vérifier si toutes les données existent avant d'insérer dans la base de donnée
        // TODO afficher une erreur sur le formulaire
        if ($name & $subtitle & $picture & $home_order) {
            $categoryModel = new Category;
            $category = $categoryModel->find($id);
            $category->setName($name);
            $category->setSubtitle($subtitle);
            $category->setPicture($picture);
            $category->setHomeOrder($home_order);
            $validate = $category->update();
        }
        

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        if ($validate) { $this->mod($id, true);
        } else {
            $this->mod($id);
        }
    }
}
