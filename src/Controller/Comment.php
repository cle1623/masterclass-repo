<?php

namespace Masterclass\Controller;

use Masterclass\Model\Comment as ModelComment;

/**
 * Comment Controller for Masterclass
 * @package Masterclass\Model
 */
class Comment
{

    /**
     * @var ModelComment
     */
    protected $model_comment;

    public function __construct(ModelComment $comment)
    {
        $this->model_comment = $comment;
    }

    public function create()
    {
        if (!isset($_SESSION['AUTHENTICATED'])) {
            die('not auth');
            header("Location: /");
            exit;
        }

        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->model_comment->insertComment($_SESSION['username'], $_POST['story_id'], $comment);

        header("Location: /story?id=".$_POST['story_id']);
    }

}