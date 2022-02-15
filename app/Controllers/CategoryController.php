<?php

namespace App\Controllers;

// Si j'ai besoin du Model Category
// use App\Models\Category;

class CategoryController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function categorieAction()
    {
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('category/categorie');
    }

    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function category_addAction()
    {
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('category/categorie_add');
    }
}
