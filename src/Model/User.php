<?php
namespace Masterclass\Model;

use Masterclass\DatabaseLayer\AbstractDb;

/**
 * User Model for Masterclass
 * @package Masterclass\Model
 */
class User
{

    /**
     * @var AbstractDb
     */
    protected $db;

    public function __construct(AbstractDb $db)
    {
        $this->db = $db;
    }

    /**
     * Insert user into db
     * @param string $username
     * @param string $email
     * @param string $pw
     */
    public function insertUser($username, $email, $pw)
    {
        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        $bind = [$username, $email, md5($username.$pw)];
        $this->db->execute($sql, $bind);
    }

    /**
     * Check if username already exists
     * @param string $username
     * @return bool
     */
    public function checkUsernameExists($username)
    {
        $sql = 'SELECT * FROM user WHERE username = ?';
        $bind = [$username];
        return ($this->db->rowCount($sql, $bind) > 0);
    }

    /**
     * Update a user's password
     * @param string $username
     * @param string $pw
     */
    public function updateUserPassword($username, $pw)
    {
        $sql = 'UPDATE user SET password = ? WHERE username = ?';
        $bind = [md5($username.$pw), $username]; // THIS IS NOT SECURE.
        $this->db->execute($sql, $bind);
    }

    /**
     * Return user data
     * @param string $username
     * @return array
     */
    public function getUser($username)
    {
        $sql = 'SELECT * FROM user WHERE username = ?';
        $bind = [$username];
        return $this->db->fetchOne($sql, $bind);
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
        $bind = [$username, $password];
        $count = $this->db->rowCount($sql, $bind);
        if ($count > 0) {
            return $this->db->fetchOne($sql, $bind);
        }
        return null;
    }
}