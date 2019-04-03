<?php

namespace Rockschtar\WordPress\AdminPage\Views;

class AdminPage implements AdminPageViewInterface {
    /**
     * @var
     */
    private $content;
    /**
     * @var
     */
    private $page_headline;
    /**
     * @var
     */
    private $content_headline;
    /**
     * @var
     */
    private $sub_headline;

    /**
     * @var AdminPageWidget[]
     */
    private $sidebar_widgets = [];
    /**
     * @var
     */
    private $id;

    public function __construct($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getContent(): ?string {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void {
        $this->content = $content;
    }

    public function addContent($content): void {
        $this->content .= $content;
    }

    /**
     * @return mixed
     */
    public function getPageHeadline(): ?string {
        return $this->page_headline;
    }

    /**
     * @param mixed $page_headline
     */
    public function setPageHeadline(?string $page_headline): void {
        $this->page_headline = $page_headline;
    }

    /**
     * @return mixed
     */
    public function getContentHeadline(): ?string {
        return $this->content_headline;
    }

    /**
     * @param mixed $content_headline
     */
    public function setContentHeadline(?string $content_headline): void {
        $this->content_headline = $content_headline;
    }

    /**
     * @return mixed
     */
    public function getSubHeadline() {
        return $this->sub_headline;
    }

    /**
     * @param mixed $sub_headline
     */
    public function setSubHeadline(?string $sub_headline): void {
        $this->sub_headline = $sub_headline;
    }

    final public function displayView(): void {
        echo $this->getView();
    }

    final public function getView(): string {

        $post_body_class = 'columns-1';

        if ($this->hasSidebarWidgets()) {
            $post_body_class = 'columns-2';
        }

        $view = empty($this->page_headline) ? '' : "<h2>{$this->page_headline}</h2>\n";
        $view .= "<div class=\"wrap\" id=\"{$this->getId()}\">\n";
        $view .= "<div id=\"icon-options-general\" class=\"icon32\"></div>\n";
        $view .= empty($this->sub_headline) ? '' : "<h1>{$this->sub_headline}</h1>\n";
        $view .= "<div id=\"poststuff\">\n";
        $view .= "<div id=\"post-body\" class=\"metabox-holder $post_body_class\">\n";
        $view .= "<div id=\"post-body-content\">\n";
        $view .= "<div class=\"meta-box-sortables ui-sortable\">\n";
        $view .= "<div class=\"postbox\">\n";
        $view .= empty($this->content_headline) ? '' : "<h2><span>{$this->content_headline}</span></h2>\n";
        $view .= "<div class=\"inside\">\n";
        $view .= "<p>{$this->content}</p>\n";
        $view .= "</div>\n";
        $view .= "</div>\n";
        $view .= "</div>\n";
        $view .= "</div>\n";
        if ($this->hasSidebarWidgets()) {
            $view .= "<div id=\"postbox-container-1\" class=\"postbox-container\">\n";
            $view .= "<div class=\"meta-box-sortables\">\n";
            foreach ($this->sidebar_widgets as $sidebar_widget) {
                $view .= $sidebar_widget->getView();
            }
            $view .= "</div>\n";
            $view .= "</div>\n";
        }
        $view .= "</div>\n";
        $view .= "<br class=\"clear\">\n";
        $view .= "</div>\n";
        $view .= '</div>';

        return $view;
    }

    public function hasSidebarWidgets(): bool {
        return $this->getSidebarWidgetsCount() > 0;
    }

    public function getSidebarWidgetsCount(): int {
        return count($this->sidebar_widgets);
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(string $id): void {
        $this->id = $id;
    }

    public function addSidebarWidget(AdminPageWidget $sidebar_widget): void {
        $this->sidebar_widgets[] = $sidebar_widget;
    }
}