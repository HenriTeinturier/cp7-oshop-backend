<?php

namespace App\Controllers;

use App\Models\Tag;
use App\Models\Type;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;

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
        // besoin des categories pour ajouter à la liste des categories du formulaire
        $categoriesModel = new Category;
        $categories = $categoriesModel->findAll();
        // besoin des Marques pour ajouter à la liste des marques du formulaire
        $brandsModel = new Brand;
        $brands = $brandsModel->findAll();
        // besoin des types pour ajouter à la liste des types du formulaire
        $typesModel = new Type;
        $types = $typesModel->findAll();


        $data = [
            'categories' => $categories,
            'brands' => $brands,
            'types' => $types,
        ];
        
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('product/product_add', $data);
    }

     /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function create()
    {
        
        $name = filter_input(INPUT_POST, 'name');
        $description = filter_input(INPUT_POST, 'description');
        $picture = filter_input(INPUT_POST, 'picture');
        $price = filter_input(INPUT_POST, 'price');
        $category_id = filter_input(INPUT_POST, 'category_id');
        $brand_id = filter_input(INPUT_POST, 'brand_id');
        $type_id = filter_input(INPUT_POST, 'type_id');

        // vérifier si toutes les données existent avant d'insérer dans la base de donnée
        // TODO afficher une erreur sur le formulaire
        if ($name & $description & $picture & $price & $category_id & $brand_id & $type_id) {
            $product = new Product;
            $product->setName($name);
            $product->setDescription($description);
            $product->setPicture($picture);
            $product->setPrice($price);
            $product->setCategoryId($category_id);
            $product->setBrandId($brand_id);
            $product->setTypeId($type_id);
            
            
    
            $product->insert();
        }
        

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->list();
        
        
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        //$this->show('product/product_add', $data);
    }

        /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function mod($params, $validate=false)
    {

         // besoin des categories pour ajouter à la liste des categories du formulaire
         $categoriesModel = new Category;
         $categories = $categoriesModel->findAll();
         // besoin des Marques pour ajouter à la liste des marques du formulaire
         $brandsModel = new Brand;
         $brands = $brandsModel->findAll();
         // besoin des types pour ajouter à la liste des types du formulaire
         $typesModel = new Type;
         $types = $typesModel->findAll();

        $tags = Tag::findAll();
        

        $producttags = Tag::getTags($params);
        

        $productModel = new Product;
        $product = $productModel->find($params);

        $data =[
            'product' => $product, // produit à modifier
            'productTags' => $producttags, // list des tags du produit à modifier
            'categories' => $categories, // list des catégories
            'brands' => $brands, //list des marques
            'types' => $types, //list des types
            'validate' => $validate, //validation du formulaire
            'tags' => $tags,  // list des tags
        ];
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('product/product_mod',$data);
    }

    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function modValid($id)
    {
        
        

        // si toutes les valeurs sont vides, return null
        // sinon tableau avec la liste des id de tags
        $tagsArray = filter_input(INPUT_POST, 'tags', FILTER_DEFAULT , FILTER_REQUIRE_ARRAY);
        // s'il n'y a pas de tableau de tags alors il n'y a pas de tags
        // alors on efface tout les tags de produc-id dans la table intermediaire
        // sinon on efface tout puis on ajoute tout dans cette même table
        if ($tagsArray) {
                // on efface puis on ajoute tous les tags
                
                Product::deleteAllProductId($id);
                // on ajoute tous les tags:
                
                foreach($tagsArray as $tag) {
                    Product::insertProductTag($id, $tag);
                }
             
            } else {

                // on efface tous les tags
                Product::deleteAllProductId($id);
            }
        
        
        $name = filter_input(INPUT_POST, 'name');
        $description = filter_input(INPUT_POST, 'description');
        $picture = filter_input(INPUT_POST, 'picture');
        $price = filter_input(INPUT_POST, 'price');
        $category_id = filter_input(INPUT_POST, 'category_id');
        $brand_id = filter_input(INPUT_POST, 'brand_id');
        $type_id = filter_input(INPUT_POST, 'type_id');
        
        // vérifier si toutes les données existent avant d'insérer dans la base de donnée
        // TODO afficher une erreur sur le formulaire
        if ($name & $description & $picture & $price & $category_id & $brand_id & $type_id) {
            $productModel = new Product;
            $product = $productModel->find($id);
            $product->setName($name);
            $product->setDescription($description);
            $product->setPicture($picture);
            $product->setPrice($price);
            $product->setCategoryId($category_id);
            $product->setBrandId($brand_id);
            $product->setTypeId($type_id);
            $validate = $product->update();
        }
        

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        if ($validate) { $this->mod($id, true);
        } else {
            $this->mod($id);
        }
    }

    public function deleteProduct($id) {

        $isDeleted = Product::delete($id);
        
        
        header("Location: /produit");

        
        
    }
}
