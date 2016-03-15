<?php
namespace Masterclass\Model;

use PDO;

/**
 * User Model for Masterclass
 * @package Masterclass\Model
 */
class User
{

    /**
     * @var PDO
     */
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Insert user into db
     * @param string $username
     * @param string $email
     * @param string $pw
     */
    public function insertUser($username, $email, $pw)
    {
        $params = array(
            $username,
            $email,
            md5($username . $pw),
        );

        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    /**
     * Check if username already exists
     * @param string $username
     * @return bool
     */
    public function checkUsernameExists($username)
    {
        $check_sql = 'SELECT * FROM user WHERE username = ?';
        $check_stmt = $this->pdo->prepare($check_sql);
        $check_stmt->execute(array($username));
        return $check_stmt->rowCount() > 0;
    }

    /**
     * Update a user's password
     * @param string $username
     * @param string $pw
     */
    public function updateUserPassword($username, $pw)
    {
        $sql = 'UPDATE user SET password = ? WHERE username = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(
            md5($username . $pw), // THIS IS NOT SECURE.
            $username,
        ));
    }

    /**
     * Return user data
     * @param string $username
     * @return array
     */
    public function getUser($username)
    {
        $dsql = 'SELECT * FROM user WHERE username = ?';
        $stmt = $this->pdo->prepare($dsql);
        $stmt->execute(array($username));
        $details = $stmt->fetch(PDO::FETCH_ASSOC);
        return $details;
    }

    /**
     * Return user login data
     * @param $username
     * @param $pw
     * @return mixed|null
     */
    public function getUserLogin($username, $pw)
    {
        $password = md5($username . $pw); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
        $sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($username, $password));
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
        return null;
    }
}