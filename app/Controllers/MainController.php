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

        // la je verifie
        // $this->checkAuthorization( [ 'catalog-manager', 'admin', 'superadmin' ] );

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/home', $data);
    }

    public function erreur403() {

        $this->show('main/error403');
    }

}
