<?php

namespace Masterclass\Controller;

use Masterclass\Model\Story as ModelStory;
use Masterclass\Model\Comment as ModelComment;

/**
 * Story Controller for Masterclass
 * @package Masterclass\Model
 */
class Story
{

    /**
     * @var ModelStory
     */
    protected $modal_story;

    /**
     * @var ModelComment
     */
    protected $model_comment;

    public function __construct(ModelStory $story, ModelComment $comment)
    {
        $this->model_story = $story;
        $this->model_comment = $comment;
    }

    public function index()
    {
        if (!isset($_GET['id'])) {
            header("Location: /");
            exit;
        }

        $story = $this->model_story->getStory($_GET['id']);
        if (empty($story)) {
            header("Location: /");
            exit;
        }

        $comments = $this->model_comment->getCommentsByStoryId($story['id']);

        $content = '
            <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
            <span class="details">' . $story['created_by'] . ' | ' . count($comments) . ' Comments |
            ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
        ';

        if (isset($_SESSION['AUTHENTICATED'])) {
            $content .= '
            <form method="post" action="/comment/create">
            <input type="hidden" name="story_id" value="' . $_GET['id'] . '" />
            <textarea cols="60" rows="6" name="comment"></textarea><br />
            <input type="submit" name="submit" value="Submit Comment" />
            </form>            
            ';
        }

        foreach ($comments as $comment) {
            $content .= '
                <div class="comment"><span class="comment_details">' . $comment['created_by'] . ' | ' .
                date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                ' . $comment['comment'] . '</div>
            ';
        }

        require realpath(__DIR__ . '/../../layout.phtml');

    }

    public function create()
    {
        if (!isset($_SESSION['AUTHENTICATED'])) {
            header("Location: /user/login");
            exit;
        }

        $error = '';
        if (isset($_POST['create'])) {
            if (!isset($_POST['headline']) || !isset($_POST['url']) ||
                !filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL)
            ) {
                $error = 'You did not fill in all the fields or the URL did not validate.';
            } else {
                $id = $this->model_story->insertStory($_POST['headline'], $_POST['url'], $_SESSION['username']);
                header("Location: /story/?id=$id");
                exit;
            }
        }

        $content = '
            <form method="post">
                ' . $error . '<br />
        
                <label>Headline:</label> <input type="text" name="headline" value="" /> <br />
                <label>URL:</label> <input type="text" name="url" value="" /><br />
                <input type="submit" name="create" value="Create" />
            </form>
        ';

        require realpath(__DIR__ . '/../../layout.phtml');
    }

}