<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 21/10/18
 * Time: 08:48
 */

namespace Model;

class FastSearchManager extends AbstractManager
{
    const TABLE = 'announce';

    /**
     *  Initializes this class.
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct(self::TABLE, $pdo);
    }

    public function selectSearch(string $q)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE city LIKE %. '$q'.% ORDER BY id DESC");
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->bindValue('city', $city, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}
