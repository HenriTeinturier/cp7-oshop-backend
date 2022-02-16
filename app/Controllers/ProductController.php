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
    public function list()
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
    public function add()
    {
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('product/product_add');
    }

        /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function mod($params)
    {

        $productModel = new Product;
        $product = $productModel->find($params);

        $data =[
            'product' => $product,
        ];
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('product/product_mod',$data);
    }
}
