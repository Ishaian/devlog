<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace Model;

/**
 *
 */
class AnnounceManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'announce';

    /**
     *  Initializes this class.
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct(self::TABLE, $pdo);
    }

    /**
     * @param Item $item
     * @return int
     */
    public function insert(Announce $announce): int
    {
// prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (`title`, `content`, `price`,
                                                    `capacity`,`city`,`good`,`activity`) 
                                                   VALUES (:title, :content, :price,
                                                    :capacity,:city, :good,:activity)");
        $statement->bindValue('title', $announce->getTitle(), \PDO::PARAM_STR);
        $statement->bindValue('content', $announce->getContent(), \PDO::PARAM_STR);
        $statement->bindValue('price', $announce->getPrice(), \PDO::PARAM_INT);
        $statement->bindValue('capacity', $announce->getCapacity(), \PDO::PARAM_INT);
        $statement->bindValue('city', $announce->getCity(), \PDO::PARAM_STR);
        $statement->bindValue('good', $announce->getGood(), \PDO::PARAM_STR);
        $statement->bindValue('activity', $announce->getActivity(), \PDO::PARAM_STR);
        if ($statement->execute()) {
            return $this->pdo->lastInsertId();
        }
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
// prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * @param Item $item
     * @return int
     */
    public function update(Announce $announce): int
    {
// prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table 
                                                   SET `title` = :title ,`content` = :content ,`price` = :price , 
                                                   `capacity` = :capacity , `city` = :city, `good` = :good ,
                                                   `activity` = :activity
                                                   WHERE id=:id");
        $statement->bindValue('id', $announce->getId(), \PDO::PARAM_INT);
        $statement->bindValue('title', $announce->getTitle(), \PDO::PARAM_STR);
        $statement->bindValue('content', $announce->getContent(), \PDO::PARAM_STR);
        $statement->bindValue('price', $announce->getPrice(), \PDO::PARAM_INT);
        $statement->bindValue('capacity', $announce->getCapacity(), \PDO::PARAM_INT);
        $statement->bindValue('city', $announce->getCity(), \PDO::PARAM_STR);
        $statement->bindValue('good', $announce->getGood(), \PDO::PARAM_STR);
        $statement->bindValue('activity', $announce->getActivity(), \PDO::PARAM_STR);
        return $statement->execute();
    }

    public function updateImg(Announce $announce): int
    {
// prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `img`=:img WHERE id=:id");
        $statement->bindValue('img', $announce->getImg(), \PDO::PARAM_STR);
        $statement->bindValue('id', $announce->getId(), \PDO::PARAM_INT);
        return $statement->execute();
    }


    public function selectByCity(string $city)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM  $this->table  WHERE city LIKE  :city");
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->bindValue('city', "%$city%", \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectBySearch(array $search)
    {
        $query = "SELECT * FROM  $this->table  WHERE 1";


        if (!empty($search['city'])) {
            $query .= " AND city LIKE :city";
        }
        if (!empty($search['good'])) {
            $query .= " AND good LIKE :good";
        }
        if (!empty($search['price']) && ($search['price']) > 0) {
            $query .= " AND price <= :price";
        }
        if (!empty($search['capacity']) && ($search['capacity']) > 0) {
            $query .= " AND capacity >= :capacity";
        }
        if (!empty($search['activity'])) {
            $query .= " AND activity LIKE :activity";
        }

        $statement = $this->pdo->prepare($query);

        if (!empty($search['city'])) {
            $statement->bindValue('city', "%" . $search['city'] . "%", \PDO::PARAM_STR);
        }
        if (!empty($search['price'])) {
            $statement->bindValue('price', $search['price'], \PDO::PARAM_INT);
        }
        if (!empty($search['good'])) {
            $statement->bindValue('good', "%" . $search['good'] . "%", \PDO::PARAM_STR);
        }
        if (!empty($search['capacity'])) {
            $statement->bindValue('capacity', $search['capacity'], \PDO::PARAM_INT);
        }
        if (!empty($search['activity'])) {
            $statement->bindValue('activity', "%" . $search['activity'] . "%", \PDO::PARAM_STR);
        }

        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->execute();

        return $statement->fetchAll();
    }
}
