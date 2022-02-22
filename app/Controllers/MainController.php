<?php

namespace App\Controllers;

use App\Models\AppUser;
use App\Models\Product;
use App\Models\Category;

// Si j'ai besoin du Model Category
// use App\Models\Category;

class MainController extends CoreController
{

    public function homepage() {

        $categoriesModel = new Category;
        $categories = $categoriesModel->findAll();

        $data = [
            'categories' => $categories,
        ];

        $this->show('main/homepage', $data);
    }

    public function homepageValid() {

        // remise à 0 du home_order de toutes les catégories
        // peut être faudrait il améliorer en remettant à 0 uniquement si le home order > 0?
        Category::updateHomeOrderTo0();
        

       // je récupère un tableau
       // 0 = id de la catégorie qui sera home_order =1
       // 1 = id de la catégorie qui sera hoome_order = 2 ...
       // jusque 4 donc 5
        $classement_order = filter_input(INPUT_POST, 'emplacement', FILTER_DEFAULT , FILTER_REQUIRE_ARRAY);
        dump($classement_order);
        for ($i=0; $i < 5 ; $i++) { 
           $idCategoryToChange = $classement_order[$i];
           $categorieModel = new Category;
           $categorie = $categorieModel->find($idCategoryToChange);
           $categorie->setHomeOrder($i+1);
           $categorie->update();
        }
        


        
        $this->homepage();
    }

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
