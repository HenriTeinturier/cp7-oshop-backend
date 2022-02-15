<?php

namespace App\Controllers;

use App\Models\Product;

// Si j'ai besoin du Model Category
// use App\Models\Category;

class ProductController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function productAction()
    {
        $productsModel = new Product;
        $products = $productsModel->findAll();

        $data = [
            'products'=> $products,
        ];

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('product/product',$data);
    }

    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function produit_addAction()
    {
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('product/product_add');
    }
}
