<?php
/**
 * Created by PhpStorm.
 * User: lilian
 * Date: 29/10/18
 * Time: 14:44
 */

namespace Model;

class User
{
    private $id;
    private $lastname;
    private $firstname;
    private $email;
    private $password;
    private $pseudo;
    public function getId(): int
    {
        return $this->id;
    }
    public function setId($id): User
    {
        $this->id = $id;
        return $this;
    }
    public function getLastname(): string
    {
        return $this->lastname;
    }
    public function setLastname($lastname): User
    {
        $this->lastname = $lastname;
        return $this;
    }
    public function getFirstname(): string
    {
        return $this->firstname;
    }
    public function setFirstname($firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail($email): User
    {
        $this->email = $email;
        return $this;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword($password): User
    {
        $this->password = $password;
        return $this;
    }
    public function getPseudo(): string
    {
        return $this->pseudo;
    }
    public function setPseudo($pseudo): User
    {
        $this->pseudo = $pseudo;
        return $this;
    }
}
