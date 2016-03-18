<?php

namespace Masterclass\Model;

use Masterclass\DatabaseLayer\AbstractDb;

/**
 * Story Model for Masterclass
 * @package Masterclass\Model
 */
final class Story
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
        return $this->db->fetchAll($sql);
    }

    /**
     * Return story data
     * @param int $story_id
     * @return mixed|null
     */
    public function getStory($story_id)
    {
        $sql = 'SELECT * FROM story WHERE id = ?';
        $bind = [$story_id];
        return $this->db->fetchOne($sql, $bind);
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
        $bind = [$headline, $url, $username];
        $this->db->execute($sql, $bind);
        return $this->db->lastInsertId();
    }
}