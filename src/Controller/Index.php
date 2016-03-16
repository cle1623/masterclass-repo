<?php

namespace Masterclass\Controller;

use Masterclass\Model\Story as ModelStory;

/**
 * Index Controller for Masterclass
 * @package Masterclass\Model
 */
class Index
{

    /**
     * @var ModelStory
     */
    protected $model_story;

    public function __construct(ModelStory $story)
    {
        $this->model_story = $story;
    }

    /**
     * display index
     */
    public function index()
    {
        $stories = $this->model_story->getStories();

        $content = '<ol>';

        foreach ($stories as $story) {
            $content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story/?id=' . $story['id'] . '">' . $story['count'] . ' Comments</a> |
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        }

        $content .= '</ol>';

        require realpath(__DIR__ . '/../../layout.phtml');
    }
}

