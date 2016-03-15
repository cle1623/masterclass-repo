<?php

namespace Masterclass\Model;

use PDO;

/**
 * Comment Model for Masterclass
 * @package Masterclass\Model
 */
class Comment
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
     * Return all comments belonging to a story
     * @param int $story_id
     * @return array
     */
    public function getCommentsByStoryId($story_id)
    {
        $comment_sql = 'SELECT * FROM comment WHERE story_id = ?';
        $comment_stmt = $this->pdo->prepare($comment_sql);
        $comment_stmt->execute(array($story_id));
        $comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
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
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(
            $username,
            $story_id,
            $comment,
        ));
    }
}