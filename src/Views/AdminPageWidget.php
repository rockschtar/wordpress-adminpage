<?php

namespace Rockschtar\WordPress\AdminPage\Views;

class AdminPageWidget implements AdminPageViewInterface
{
    private $id;
    private $headline;
    private $content;

    public function __construct(string $id, ?string $headline = '')
    {
        $this->id = $id;
        $this->headline = $headline;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function setHeadline(string $headline): void
    {
        $this->headline = $headline;
    }

    public function displayView(): void
    {
        echo $this->getView();
    }

    public function getView(): string
    {
        $view = "<div class=\"postbox\" id=\"{$this->id}\">\n";
        $view .= "<h2><span>{$this->headline}</span></h2>\n";
        $view .= "<div class=\"inside\">\n";
        $view .= "<p>{$this->content}</p>\n";
        $view .= "</div>\n";
        $view .= "</div>\n";
        return $view;
    }
}
