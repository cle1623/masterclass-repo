<?php

namespace Masterclass\Model;

use Masterclass\DatabaseLayer\AbstractDb;

/**
 * Comment Model for Masterclass
 * @package Masterclass\Model
 */
class Comment
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
     * Return all comments belonging to a story
     * @param int $story_id
     * @return array
     */
    public function getCommentsByStoryId($story_id)
    {
        $sql = 'SELECT * FROM comment WHERE story_id = ?';
        $bind = [$story_id];
        return $this->db->fetchAll($sql, $bind);
    }

    /**
     * Insert comment into db
     * @param string $username
     * @param int $story_id
     * @param string $comment
     */
    public function insertComment($username, $story_id, $comment)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $bind = [$username, $story_id, $comment];
        $this->db->execute($sql, $bind);
    }
}