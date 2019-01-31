<?php
/**
 * Created by PhpStorm.
 * User: lilian
 * Date: 29/10/18
 * Time: 14:45
 */

namespace Model;

use \PDO;

class UserManager extends AbstractManager
{
    const TABLE = 'user';
    /**
     *  Initializes this class.
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct(self::TABLE, $pdo);
    }
    public function insertUser(User $connexion): int
    {
// prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table 
                                                  (`lastname`, `firstname`, `email`, `password`,`pseudo`) 
                                                   VALUES (:lastname, :firstname, :email, :password, :pseudo)");
        $statement->bindValue('lastname', $connexion->getLastname(), \PDO::PARAM_STR);
        $statement->bindValue('firstname', $connexion->getFirstname(), \PDO::PARAM_STR);
        $statement->bindValue('email', $connexion->getEmail(), \PDO::PARAM_STR);
        $statement->bindValue('password', $connexion->getPassword(), \PDO::PARAM_STR);
        $statement->bindValue('pseudo', $connexion->getPseudo(), \PDO::PARAM_STR);
        if ($statement->execute()) {
            return $this->pdo->lastInsertId();
        }
    }
    public function connectUser(string $email, string $password)
    {
// prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE email = :email AND password = :password");
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->bindValue(':password', $password, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }
}
