<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function selectOneByEmail(string $email)
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE email = :email";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch();
        return $user;
    }

    public function insert(array $credentials)
    {
        $query = "INSERT INTO " . self::TABLE . " (email, password, pseudo, firstname, lastname) 
                  VALUES (:email, :password, :pseudo, :firstname, :lastname)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':email', $credentials['email']);
        $statement->bindValue(':password', password_hash($credentials['password'], PASSWORD_DEFAULT));
        $statement->bindValue(':pseudo', $credentials['pseudo']);
        $statement->bindValue(':firstname', $credentials['firstname']);
        $statement->bindValue(':lastname', $credentials['lastname']);
        $statement->execute();

        return (int)$this->pdo->lastInsertId();
    }
}
