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

        $name = filter_input(INPUT_POST, 'name');
        $subtitle = filter_input(INPUT_POST, 'subtitle');
        $picture = filter_input(INPUT_POST, 'picture');
        $home_order = filter_input(INPUT_POST, 'home_order');
        // vérifier si toutes les données existent avant d'insérer dans la base de donnée
        // TODO afficher une erreur sur le formulaire
        if ($name & $subtitle & $picture & $home_order) {
            $category = new Category;
            $category->setName($name);
            $category->setSubtitle($subtitle);
            $category->setPicture($picture);
            $category->setHomeOrder($home_order);
    
            $category->insert();
        }
        

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->list();
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
