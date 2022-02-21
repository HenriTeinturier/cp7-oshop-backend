<?php

namespace App\Models;

use PDO;
use App\Utils\Database;

class AppUser extends CoreModel
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $role;

    /**
     * @var int
     */
    private $status;

    public function find($id)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `app_user` WHERE `id` =' . $id;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $user = $pdoStatement->fetchObject('App\Models\AppUser');

        // retourner le résultat
        return $user;
    }

    static function findByEmail($email)
    {
         // se connecter à la BDD
         $pdo = Database::getPDO();

         // écrire notre requête
         $sql = "SELECT * FROM `app_user` WHERE `email` =:email";

         // preparation pour eviter une injection sql de l'utilisateur
         $statement = $pdo->prepare($sql);
 
         // exécuter notre requête
        //  $statement = $pdo->query($sql);
        
        // j'explique comment utiliser les étiquettes:
        $statement->bindValue(":email", $email, PDO::PARAM_STR);

         //j'execute ma requette préparée
         // attention ne reoutne pas un jeu de resultat. La variable $statement contient désormais le jue de résultat.
         $statement->execute();

         // on demande à la requette préparée désormais éxecutée de nous donner les resultats
         $user = $statement->fetchObject('App\Models\AppUser');
        
         // retourner le résultat
         return $user;
    }

    public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $users = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\AppUser');

        return $users;
    }

    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        $sql = "
            INSERT INTO `app_user` (email, password, firstname, lastname, role, status)
            VALUES ('{$this->email}', '{$this->password}', '{$this->firstname}', '{$this->lastname}', '{$this->rolde}', '{$this->status}' )
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

    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE à utiliser avec prépare
        $sql = "
            UPDATE `app_user`
            SET
                email = :email,
                password = :password,
                firstname = :firstname,
                lastname = :lastname,
                role = :role,
                status = :status,
                updated_at = NOW()
                
            WHERE id = :id
        ";

        // préparation de la reqsuête
        $statement = $pdo->prepare ($sql);

        // execution de la requete de mise à jour
        $updatedRows = $statement->execute([
            ":email" =>  $this->email,
            ":password" => $this->password,
            ":firstname" => $this->firstname,
            ":lastname" => $this->lastname,
            ":role" => $this->role,
            ":status" => $this->status,
            ":id" => $this->id,

        ]);

        // Execution de la requête de mise à jour (exec, pas query)
        // $updatedRows = $pdo->exec($sql);

        // On retourne VRAI, si au moins une ligne ajoutée
        return ($updatedRows > 0);
    }

    static function delete($id)
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE
        $sql = "DELETE FROM `app_user` 
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

    /**
     * Get the value of email
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Get the value of password
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * Get the value of firstname
     *
     * @return  string
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  string  $firstname
     */ 
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get the value of lastname
     *
     * @return  string
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string  $lastname
     */ 
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get the value of role
     *
     * @return  string
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @param  string  $role
     */ 
    public function setRole(string $role)
    {
        $this->role = $role;
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
}