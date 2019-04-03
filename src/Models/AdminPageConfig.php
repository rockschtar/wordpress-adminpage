<?php


namespace Rockschtar\WordPress\AdminPage\Models;


class AdminPageConfig {
    private $submenu = false;
    private $parent_slug = '';
    private $page_title = '';
    private $menu_title = '';
    private $capability = '';
    private $menu_slug = '';
    private $icon_url = '';
    private $menu_position;

    public static function init(): AdminPageConfig {

        return new self();
    }


    /**
     * @return mixed
     */
    public function getParentSlug() {
        return $this->parent_slug;
    }

    /**
     * @param mixed $parent_slug
     * @return $this
     */
    public function setParentSlug($parent_slug): self {
        $this->parent_slug = $parent_slug;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPageTitle() {
        return $this->page_title;
    }

    /**
     * @param mixed $page_title
     * @return $this
     */
    public function setPageTitle($page_title): self {
        $this->page_title = $page_title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMenuTitle() {
        return $this->menu_title;
    }

    /**
     * @param mixed $menu_title
     * @return $this
     */
    public function setMenuTitle($menu_title): self {
        $this->menu_title = $menu_title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCapability() {
        return $this->capability;
    }

    /**
     * @param mixed $capability
     * @return $this
     */
    public function setCapability($capability): self {
        $this->capability = $capability;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMenuSlug() {
        return $this->menu_slug;
    }

    /**
     * @param mixed $menu_slug
     * @return $this
     */
    public function setMenuSlug($menu_slug): self {
        $this->menu_slug = $menu_slug;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIconUrl() {
        return $this->icon_url;
    }

    /**
     * @param mixed $icon_url
     * @return $this
     */
    public function setIconUrl($icon_url): self {
        $this->icon_url = $icon_url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMenuPosition() {
        return $this->menu_position;

    }

    /**
     * @param mixed $menu_position
     * @return $this
     */
    public function setMenuPosition($menu_position): self {
        $this->menu_position = $menu_position;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSubmenu(): bool {
        return $this->submenu;
    }

    /**
     * @param bool $submenu
     * @return $this
     */
    public function setSubmenu(bool $submenu): self {
        $this->submenu = $submenu;
        return $this;
    }
}