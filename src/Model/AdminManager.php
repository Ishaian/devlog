<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 20/10/18
 * Time: 10:59
 */

namespace Model;

class AdminManager extends AbstractManager
{
    const TABLE = 'announce';

    /**
     *  Initializes this class.
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct(self::TABLE, $pdo);
    }
    public function deleteAdmin(int $id)
    {
// prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
    public function updateAdmin(Announce $announce): int
    {
// prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table 
                                                   SET `title` = :title , `content` = :content ,`price` = :price , 
                                                   `capacity` = :capacity
                                                   WHERE id=:id");
        $statement->bindValue('id', $announce->getId(), \PDO::PARAM_INT);
        $statement->bindValue('title', $announce->getTitle(), \PDO::PARAM_STR);
        $statement->bindValue('content', $announce->getContent(), \PDO::PARAM_STR);
        $statement->bindValue('price', $announce->getPrice(), \PDO::PARAM_INT);
        $statement->bindValue('capacity', $announce->getCapacity(), \PDO::PARAM_INT);
        return $statement->execute();
    }
}
