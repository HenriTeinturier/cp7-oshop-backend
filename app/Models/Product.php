<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Une instance de Product = un produit dans la base de données
 * Product hérite de CoreModel
 */
class Product extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var float
     */
    private $price;
    /**
     * @var int
     */
    private $rate;
    /**
     * @var int
     */
    private $status;
    /**
     * @var int
     */
    private $brand_id;
    /**
     * @var int
     */
    private $category_id;
    /**
     * @var int
     */
    private $type_id;

    private $product_id;
    private $tag_id;
   

    /**
     * Méthode permettant de récupérer un enregistrement de la table Product en fonction d'un id donné
     *
     * @param int $productId ID du produit
     * @return Product
     */
    public function find($productId)
    {
        // récupérer un objet PDO = connexion à la BDD
        $pdo = Database::getPDO();

        // on écrit la requête SQL pour récupérer le produit
        $sql = '
            SELECT *
            FROM product
            WHERE id = ' . $productId;

        // query ? exec ?
        // On fait de la LECTURE = une récupration => query()
        // si on avait fait une modification, suppression, ou un ajout => exec
        $pdoStatement = $pdo->query($sql);

        // fetchObject() pour récupérer un seul résultat
        // si j'en avais eu plusieurs => fetchAll
        $result = $pdoStatement->fetchObject('App\Models\Product');

        return $result;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     *
     * @return Product[]
     */
    public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `product`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Product');

        return $results;
    }

    /**
     * Méthode permettant de récupérer les trois premiers enregistrements de la table product
     *
     * @return Product[]
     */
    public function findThreeProducts()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `product`LIMIT 3';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Product');

        return $results;
    }

    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of description
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string  $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Get the value of picture
     *
     * @return  string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @param  string  $picture
     */
    public function setPicture(string $picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of price
     *
     * @return  float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param  float  $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * Get the value of rate
     *
     * @return  int
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @param  int  $rate
     */
    public function setRate(int $rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * Get the value of brand_id
     *
     * @return  int
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @param  int  $brand_id
     */
    public function setBrandId(int $brand_id)
    {
        $this->brand_id = $brand_id;
    }

    /**
     * Get the value of category_id
     *
     * @return  int
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @param  int  $category_id
     */
    public function setCategoryId(int $category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * Get the value of type_id
     *
     * @return  int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set the value of type_id
     *
     * @param  int  $type_id
     */
    public function setTypeId(int $type_id)
    {
        $this->type_id = $type_id;
    }

     /**
     * Méthode permettant d'ajouter un enregistrement dans la table Product
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO 
        $sql = "
            INSERT INTO `product` (name, description, picture, price, brand_id, category_id, type_id)
            VALUES ('{$this->name}', '{$this->description}', '{$this->picture}', '{$this->price}' , '{$this->brand_id}', '{$this->category_id}', '{$this->type_id}')
        ";

        // Execution de la requête d'insertion (exec, pas query)
        $insertedRows = $pdo->exec($sql);
        
        // Si au moins une ligne ajoutée
        if ($insertedRows > 0) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }

        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    /**
     * Méthode permettant de mettre à jour un enregistrement dans la table brand
     * L'objet courant doit contenir l'id, et toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE
        $sql = "
            UPDATE `product`
            SET
                name = '{$this->name}',
                description = '{$this->description}',
                picture = '{$this->picture}',
                price = '{$this->price}',
                brand_id = '{$this->brand_id}',
                category_id = '{$this->category_id}',
                type_id = '{$this->type_id}',
                updated_at = NOW()
                
            WHERE id = $this->id
        ";
        
        // Execution de la requête de mise à jour (exec, pas query)
        $updatedRows = $pdo->exec($sql);

        // On retourne VRAI, si au moins une ligne ajoutée
        return ($updatedRows > 0);
    }

    /**
     * Méthode permettant de supprimer un enregistrement dans la table category
     * L'objet courant doit contenir l'id
     * @return bool
     */
    static function delete($id)
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE
        $sql = "DELETE FROM `product` 
                WHERE `id` = :id";

        // Je prépare toujours la requête de la même façon
        $statement = $pdo->prepare( $sql );

        // Je remplace successivement chaque étiquette par sa valeur
        $statement->bindValue( ":id",     $id,      PDO::PARAM_INT );

        // J'appelle execute, cette fois sans paramètre car les étiquette sont déjà remplacées ;)
        $deletedRows = $statement->execute();

        // On retourne VRAI, si au moins une ligne ajoutée
        return ($deletedRows > 0);
    }

    static function deleteAllProductId($id)
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE
        $sql = "DELETE FROM `product_has_tag` 
                WHERE `product_id` = :id";

        // Je prépare toujours la requête de la même façon
        $statement = $pdo->prepare( $sql );

        // Je remplace successivement chaque étiquette par sa valeur
        $statement->bindValue( ":id",     $id,      PDO::PARAM_INT );

        // J'appelle execute, cette fois sans paramètre car les étiquette sont déjà remplacées ;)
        $deletedRows = $statement->execute();

        // On retourne VRAI, si au moins une ligne ajoutée
        return ($deletedRows > 0);
    }

    static function insertProductTag($product_id, $tag_id)
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        $sql = "
            INSERT INTO `product_has_tag` (product_id, tag_id)
            VALUES ('{$product_id}', '{$tag_id}')
        ";

        // Execution de la requête d'insertion (exec, pas query)
        $insertedRows = $pdo->exec($sql);
        
        // Si au moins une ligne ajoutée
        
        if ($insertedRows > 0) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            // $this->id = $pdo->lastInsertId();

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }

        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    /**
     * Get the value of product_id
     */ 
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */ 
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of tag_id
     */ 
    public function getTag_id()
    {
        return $this->tag_id;
    }

    /**
     * Set the value of tag_id
     *
     * @return  self
     */ 
    public function setTag_id($tag_id)
    {
        $this->tag_id = $tag_id;

        return $this;
    }
}
