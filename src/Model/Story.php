<?php

namespace Masterclass\Model;

use PDO;

/**
 * Story Model for Masterclass
 * @package Masterclass\Model
 */
final class Story
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
     * Return all stories and comment count of each story
     * @return array
     */
    public function getStories()
    {
        $sql = <<<SQL
        SELECT
          story.*,
          (SELECT COUNT(*) FROM comment WHERE comment.story_id = story.id) as 'count'
        FROM story
        ORDER BY story.created_on DESC;
SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $stories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stories;
    }

    /**
     * Return story data
     * @param int $story_id
     * @return mixed|null
     */
    public function getStory($story_id)
    {
        $story_sql = 'SELECT * FROM story WHERE id = ?';
        $story_stmt = $this->pdo->prepare($story_sql);
        $story_stmt->execute(array($story_id));
        if ($story_stmt->rowCount() >= 1) {
            $story = $story_stmt->fetch(PDO::FETCH_ASSOC);
            return $story;
        }
        return null;
    }

    /**
     * Insert story into db
     * @param string $headline
     * @param string $url
     * @param string $username
     * @return int
     */
    public function insertStory($headline, $url, $username)
    {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(
            $headline,
            $url,
            $username,
        ));

        $id = $this->pdo->lastInsertId();
        return $id;
    }
}